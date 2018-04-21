<?php
namespace App\Library;

use App\Models\FeatureDefinition;
use App\Models\GeneAsEvent;
use App\Models\ProteinFeature;
use App\Models\Uniprot;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Search
{
    private $fd; // feature definitions
    private $pf; // protein features
    private $as; // gene AS event
    private $up; // uniprot

    public function __construct()
    {
        $this->fd = $this->getFeatureDefinition();
        $this->pf = new ProteinFeature();
        $this->as = new GeneAsEvent();
        $this->up = new Uniprot();
    }

    public function cugrGeneInfo($gene_id)
    {
        $http = new Client();
        $url = 'http://cmb.bnu.edu.cn:8088/api/cucumber/feature/name/' . $gene_id;
        $response = $http->get($url);
        $cugr_gene_data = json_decode((string) $response->getBody(), true);
        return $cugr_gene_data;
    }

    public function gene($gene)
    {
        // 获取基因的基本信息
        $cugr_gene_data = $this->cugrGeneInfo($gene);

        if ($cugr_gene_data && (!preg_match('/gene/i', $cugr_gene_data['type']))) {
            return null;
        }

        $chr = $cugr_gene_data['chr'];

        $start = min($cugr_gene_data['start'], $cugr_gene_data['end']);
        $end = max($cugr_gene_data['start'], $cugr_gene_data['end']);

        $padding = ($end - $start) * 0.5;
        $start = max(($start - $padding), 0);
        $end = $end + $padding;

        $jbrowse = 'http://cmb.bnu.edu.cn:8088/jbrowse/index.html?data=data%2Fjson%2Fcucumber&loc=' . $chr . '%3A' . $start . '..' . $end . '&tracklist=0&nav=0&overview=0&tracks=DNA%2Cfeatures';

        // 获取基因的蛋白
        $genes = $this->pf->select('protein')->where('gene', $gene)->get();
        if (!$genes) {
            return null;
        }
        $proteins = array_sort(array_unique(array_pluck($genes->toArray(), 'protein')), '');

        // 获取基因的剪切事件
        $events = $this->as->where('gene', $gene)->get();
        return [
            'chr' => $chr,
            'start' => $start,
            'end' => $end,
            'strand' => $cugr_gene_data['strand'],
            'name' => $cugr_gene_data['name']['name'],
            'jbrowse' => $jbrowse,
            'proteins' => $proteins,
            'events' => $events,
        ];
    }

    public function protein($protein)
    {
        $arr = explode('.', $protein);
        if (count($arr) != 2 && ((int) $arr[1]) < 1) {
            abort('Invalid protein ID');
        }

        $gene = $arr[0];
        $protein_idx = (int) $arr[1];

        $proteins = $this->pf->where('gene', $gene)->where('protein', $protein_idx)->with('feature')->get();
        return $proteins;
    }

    private function getFeatureDefinition()
    {
        return Cache::rememberForever('feature_definition', function () {
            $defs = (new FeatureDefinition())->all();
            $definitions = [];
            foreach ($defs as $d) {
                $definitions[$d->name] = [
                    'id' => $d->id,
                    'unit' => $d->unit ?? '',
                    'comment' => $d->comment ?? '',
                ];
            }
            return $definitions;
        });
    }

    public function uniprot($uniprot)
    {
        return $this->up->where('uniprot', $uniprot)->get();
    }
}

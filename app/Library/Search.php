<?php
namespace App\Library;

use App\Models\FeatureDefinition;
use App\Models\ProteinFeature;

class Search
{
    private $fd; // feature definitions
    private $pf; // protein features

    public function __construct()
    {
        $this->fd = $this->getFeatureDefinition();
        $this->pf = new ProteinFeature();
    }

    public function gene($gene)
    {
        $genes = $this->pf->where('gene', $gene)->with('feature')->get();
        return $genes;
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
    }
}

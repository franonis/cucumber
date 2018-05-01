<?php

namespace App\Http\Controllers;

use App\Library\FastaFile;
use App\Library\Search;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    private $search;

    public function __construct()
    {
        $this->search = new Search();
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function showSearchPage()
    {
        return view('searchPage');
    }

    public function searchGene($gene_id)
    {
        $info = $this->search->gene($gene_id);

        if (!$info) {
            return view('searchPage', ['errors' => ['Gene Not found!']]);
        }

        return view("search.genes", ['gene' => $info]);
    }

    public function searchProtein($protein_id)
    {
        $data = $this->search->proteinWithFeatures($protein_id);

        if (!$data || count($data) == 0) {
            return view('searchPage', ['errors' => ['Protein Not found!']]);
        }

        return view('search.proteins', $data);
    }

    public function searchUniprot($uniprot)
    {
        $genes = $this->search->uniprot($uniprot);
        $num = count($genes);
        if (!$genes || $num == 0) {
            return view('searchPage', ['errors' => ['Uniprot ID is not found!']]);
        } elseif ($num == 1) {
            return $this->searchGene($genes[0]->gene);
        } else {
            return view('search.selector', ['link_template' => '/search/gene/', 'queries' => $genes, 'title' => 'Choose a gene']);
        }
    }

    public function searchLocation($location)
    {
        $genes = $this->search->location($location);
        if (count($genes) == 0) {
            return redirect('/search')->with('warnings', ['No gene found!']);
        }

        return view('search.selector', ['link_template' => '/search/gene/', 'queries' => $genes, 'title' => 'Choose a gene']);
    }

    public function searchResult(Request $r)
    {
        $type = $r->get('type');
        $query = $r->get('query');

        $search = new Search();

        switch ($type) {
            case 'gene':
                if (!$query) {
                    abort("Query is required!");
                }
                return $this->searchGene($query);
            case 'protein':
                if (!$query) {
                    abort("Query is required!");
                }
                return $this->searchProtein($query);
            case 'location':
                $start = $r->get('start');
                $end = $r->get('end');
                $chr = $r->get('chr');
                return $this->searchLocation($chr . ':' . $start . '..' . $end);
            case 'uniprot':
                if (!$query) {
                    abort("Query is required!");
                }
                return $this->searchUniprot($query);
                break;
            default:
                abort('No such type!');
                break;
        }
    }

    /**
     *  比较蛋白特征
     *
     * @return
     */
    public function compareProteins(Request $r)
    {
        if (empty($r->get('proteins'))) {
            return view('errors.404', ['msg' => 'No protein provided!']);
        }

        $proteins = explode(',', $r->get('proteins'));
        foreach ($proteins as $idx => $p) {
            if (!preg_match('/Csa[\d\w]+G\d+\.\d+/', $p)) {
                unset($proteins[$idx]);
            }
        }

        $data = $this->search->proteinsWithFeatures($proteins);

        if (!$data || count($data) == 0) {
            return view('searchPage', ['errors' => ['Protein Not found!']]);
        }

        return view('search.proteins', $data);
    }

    public function downloadProteinSequence($protein)
    {
        $seq = $this->search->proteinSequence($protein);
        $fasta = '>' . $protein . "\n" . $seq;
        return response($fasta)
            ->withHeaders([
                'Content-Disposition' => 'attachment;filename="' . $protein . '.fasta"',
                'Content-Type' => 'text/plain',
                'Content-length' => strlen($fasta),
                'Connection' => 'close',
            ]);
    }

    public function blastEntry()
    {
        return view('tool.blast');
    }

    public function checkBlastResult($job)
    {
        if ($this->isBlastOver($job)) {
            dd('blast over!');
        } elseif ($this->isBlastRunning($job)) {
            return view('tool.blast_running', ['job' => $job]);
        } else {
            return view('errors.404', ['msg' => 'BLAST job not found!']);
        }
    }

    public function runBlast(Request $r)
    {
        $program = $r->program;
        $seq = $r->seq;
        $evalue = (double) $r->evalue;
        if (!in_array($program, ['blastp', 'tblastn'])) {
            return view('tool.blast', ['errors' => ['Program Not found!']]);
        }

        $prefix_name = md5($seq);
        $fa_file = storage_path('blast') . '/' . $prefix_name . '.fa';

        if ($this->isBlastOver($prefix_name)) {
            return redirect()->action('PublicController@showBlastResult', ['job' => $prefix_name]);
        }

        if ($this->isBlastRunning($prefix_name)) {
            return redirect()->action('PublicController@blastRunning', ['job' => $prefix_name]);
        }

        try {
            $fasta = new FastaFile();
            $fasta->writeToFile($seq, $fa_file);
        } catch (\Exception $e) {
            return view('tool.blast', ['errors' => [$e->getMessage()]]);
        }

        if ($evalue <= 0) {
            return view('tool.blast', ['errors' => ['Invalid e-value!']]);
        }
    }

    private function isBlastOver($prefix)
    {
        // blast结果文件存在，直接返回结果
        $blast_output_file = storage_path('blast') . '/' . $prefix . '.out';

        return file_exists($blast_output_file) ? true : false;
    }

    private function isBlastRunning($prefix)
    {
        if ($this->isBlastOver($prefix)) {
            return false;
        }

        // fasta文件存在，提醒用户仍在blast
        $fa_file = storage_path('blast') . '/' . $prefix . '.fa';
        return file_exists($fa_file) ? true : false;
    }
}

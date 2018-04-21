<?php

namespace App\Http\Controllers;

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
        $proteins = $this->search->protein($protein_id);
        if (count($proteins) == 0) {
            abort(404, 'Proteins Not found!');
        }
        return view('search.proteins', ['proteins' => $proteins]);
    }

    public function searchUniprot($uniprot)
    {
        $genes = $this->search->uniprot($uniprot);
        $num = count($genes);
        if ($num == 0) {
            return redirect('/search')->with('warnings', ['Uniprot ID is not found!']);
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
        return view('protein.compare', ['proteins' => json_encode($proteins)]);
    }
}

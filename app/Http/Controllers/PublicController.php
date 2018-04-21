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
        } else if ($num == 1) {
            return $this->searchGene($genes[0]->gene);
        } else {

        }
    }

    public function searchLocation($location)
    {
        $location = str_replace(':', '-', $location);
        $location = explode('-', $location, 3);
        $chr = $location[0];
    }

    public function searchResult(Request $r)
    {
        $type = $r->get('type');
        $query = $r->get('query');
        if (!$query) {
            abort("Query is required!");
        }

        $search = new Search();

        switch ($type) {
            case 'gene':
                return $this->searchGene($query);
                break;
            case 'protein':
                return $this->searchProtein($query);
                break;
            case 'location':
                $start = $r->get('start');
                $end = $r->get('end');
                $chr = $r->get('chr');
                return $this->searchLocation($chr . ':' . $start . '-' . $end);
                break;
            case 'uniprot':
                return $this->searchUniprot($query);
                break;
            default:
                abort('No such type!');
                break;
        }
    }
}

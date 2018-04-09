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

        $genes = $this->search->gene($gene_id);
        if (count($genes) == 0) {
            return view('searchPage', ['errors' => ['Gene Not found!']]);
        }
        return view('search.genes', ['genes' => $genes]);
    }

    public function searchProtein($protein_id)
    {
        $proteins = $this->search->protein($protein_id);
        if (count($proteins) == 0) {
            abort(404, 'Proteins Not found!');
        }
        return view('search.proteins', ['proteins' => $proteins]);
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

                break;
            case 'uniprot':

                break;
            default:
                abort('No such type!');
                break;
        }
    }
}

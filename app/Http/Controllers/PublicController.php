<?php

namespace App\Http\Controllers;

use App\Library\Search;
use GuzzleHttp\Client;
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
        $http = new Client();
        $url = 'http://cmb.bnu.edu.cn:8088/api/cucumber/feature/name/' . $gene_id;
        $response = $http->get($url);
        $data = json_decode((string) $response->getBody(), true);

        if (!preg_match('/gene/i', $data['type'])) {
            return view('searchPage', ['errors' => ['Gene Not found!']]);
        }

        $chr = $data['chr'];

        $start = $data['start'] > $data['end'] ? $data['start'] : $data['end'];
        $end = $data['start'] < $data['end'] ? $data['start'] : $data['end'];

        $start = max((2 * $start - $end), 0);
        $end = $end + ($start - $end);

        $jbrowser = 'http://cmb.bnu.edu.cn:8088/jbrowse/index.html?data=data%2Fjson%2Fcucumber&loc=' . $chr . '%3A' . $end . '..' . $start . '&tracklist=0&nav=0&overview=0&tracks=DNA%2Cfeatures';

        #return redirect($url);
        return view("search.genes");
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

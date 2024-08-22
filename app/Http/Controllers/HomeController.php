<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Cloudstudio\Ollama\Facades\Ollama;

use function Rap2hpoutre\RemoveStopWords\remove_stop_words;


class HomeController extends Controller
{
	public function home(): View {
		return view('home');
	}

	public function search(Request $request): View {
		$query = $request->input('query');
		$subject = $request->input('subject');

		$query = remove_stop_words($query);

		$query = $this->expandQueryUsingLLM($query);

		$docs = $this->getDocuments($query, $subject);

		// $docs = $this->documentRanker($docs);

		// dd($docs->data->entry);

		return view('search', ['results' => $docs->data->entry, 'feedback_search_url' => url('feedback_search')]);
	}

	public function feedbackSearch(Request $request): array {
		$query = $request->input('query');
		$subject = $request->input('subject');
		$title = $request->input('title');

		$keywords = $this->getKeywordsUsingLLM($title, $query);

		$final_query = "";

		for ($x = 0; $x < count($keywords); $x++) {
		  	if ($x < 5) {
		  		$final_query = $final_query." ".$keywords[$x];
		  	}
		}

		$docs = $this->getDocuments($final_query, "");

		// return gettype($docs->data->entry);

		return $docs->data->entry;
	}

	protected function expandQueryUsingLLM($querystring) {
		$prompt = "Generate similar keywords from '".$querystring."' and return an array named data of keyword list. Don't return additional information.";

		$response = Ollama::prompt($prompt)
		    ->model('llama2')
		    //->options(['temperature' => 0.8])
		    ->stream(false)
		    ->ask();

		$result = $response["response"];

		$start_idx = strpos($result, "[");
		$end_idx = strpos($result, "]");

		$keywords = substr($result, $start_idx + 1, $end_idx - $start_idx - 1);
		$keywords = str_replace('"',"", $keywords);

		$keywords = explode(", ",$keywords);

		$final_string = $querystring;

		for ($x = 0; $x < count($keywords); $x++) {
		  	if ($x < 5) {
		  		$final_string = $final_string." OR ".$keywords[$x];
		  	}
		}

		return $final_string;
	}

	protected function getKeywordsUsingLLM($title) {
		$prompt = "Give the keywords for the paper titled '".$title."' and return an array named data of keyword list. Don't return additional information.";

		$response = Ollama::prompt($prompt)
		    ->model('llama2')
		    //->options(['temperature' => 0.8])
		    ->stream(false)
		    ->ask();

		$result = $response["response"];

		$start_idx = strpos($result, "[");
		$end_idx = strpos($result, "]");

		$keywords = substr($result, $start_idx + 1, $end_idx - $start_idx - 1);
		$keywords = str_replace('"',"", $keywords);

		$keywords = explode(", ",$keywords);

		return $keywords;
	}

	protected function getDocuments($querystring, $subject) {
		$api_key = env('SCOPUS_API_KEY');
		$scopusSearch = new \Scopus\ScopusSearch($api_key);

		$result = $scopusSearch
        	->query($querystring)
         	// ->count(100)
         	// ->content('core')
         	->subj($subject)
         	->sort('+relevancy,-citedby-count')
         	->search();
        
        $result = str_replace("search-results","data", $result);
        $result = str_replace("dc:","", $result);
        $result = str_replace("prism:","", $result);
        $result = str_replace("@ref","type", $result);
        $result = str_replace("@href","url", $result);
        
		return json_decode($result);
	}

	protected function documentRanker($docs) {
		// this.getImpactFactor();
		// this.
		//
		//
		//

	}
}

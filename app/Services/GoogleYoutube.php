<?php 
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class GoogleYoutube {

	protected $client;
	protected $service;

	function __construct() {

		/* Get config variables */

		$client_id = Config::get('google.client_id');
		$this->client = new \Google_Client();
		$this->client->setDeveloperKey($client_id);

	}

	public function search($search, $max_results=25)
	{
		$youtube = new \Google_Service_YouTube($this->client);
		$error_message = '';
	    $videos = false;

		try {
		    // Call the search.list method to retrieve results matching the specified
		    // query term.
		    $searchResponse = $youtube->search->listSearch('id,snippet', array(
		      'q' => $search,
		      'maxResults' => $max_results,
		    ));

		    // Add each result to the appropriate list, and then display the lists of
		    // matching videos, channels, and playlists.
		    foreach ($searchResponse['items'] as $searchResult) {

		    	if ($searchResult['id']['kind'] === 'youtube#video') {
		    		$videos[] = $searchResult;
		    	}
		    }

		} catch (Google_Service_Exception $e) {
		    $error_message .= sprintf('<p>A service error occurred: <code>%s</code></p>',
		      htmlspecialchars($e->getMessage()));
		} catch (Google_Exception $e) {
		    $error_message .= sprintf('<p>An client error occurred: <code>%s</code></p>',
		      htmlspecialchars($e->getMessage()));
		}

		$response = $videos;
		if ($error_message) {
			$response = $error_message;
		};
		return $response;

	}
}
<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Google_Client;
// use App\Http\Controllers\Google_Client;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	// public function __construct()
	// {
	// 	$this->middleware('guest');
	// }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}

	public function videos(Request $request) {
		$search = $request->input('search');
		$max_results = 25;
		$api_key = 'AIzaSyCZMI3P3dTomMw0-iz8mhFcr0kjx8lakrg';

		if (!$search) {
			return false;
		};

		$client = new Google_Client();
		$client->setDeveloperKey($api_key);

		// Define an object that will be used to make all API requests.
		$youtube = new Google_Service_YouTube($client);

		try {
		    // Call the search.list method to retrieve results matching the specified
		    // query term.
		    $searchResponse = $youtube->search->listSearch('id,snippet', array(
		      'q' => $search,
		      'maxResults' => $max_results,
		    ));

		    $videos = '';
		    $channels = '';
		    $playlists = '';

		    // Add each result to the appropriate list, and then display the lists of
		    // matching videos, channels, and playlists.
		    $videos = fasel;
		    foreach ($searchResponse['items'] as $searchResult) {

		    	if ($searchResult['id']['kind'] === 'youtube#video') {
		    		$videos[] = $searchResult;
		    	}
		    }

		} catch (Google_Service_Exception $e) {
		    $message .= sprintf('<p>A service error occurred: <code>%s</code></p>',
		      htmlspecialchars($e->getMessage()));
		} catch (Google_Exception $e) {
		    $message .= sprintf('<p>An client error occurred: <code>%s</code></p>',
		      htmlspecialchars($e->getMessage()));
		}

		return view('videos')->with('videos', $videos);
	}


}

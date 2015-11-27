<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
// use App\Http\Controllers\Google_Client;
// use App\Http\Controllers\Google_Client;
use App\Services\GoogleYoutube;

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
		if (!$search) {
			return false;
		};
		$youtube =  new GoogleYoutube;
		$videos = $youtube->search($search);

		return view('videos')->with('videos', $videos);
	}


}

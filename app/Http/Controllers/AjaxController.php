<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\GoogleYoutube;

class AjaxController extends Controller
{

	public function search_videos(Request $request) {

		$search = $request->input('search');
		if (!$search) {
			return false;
		};
		$youtube =  new GoogleYoutube;
		$videos = $youtube->search($search);

		return view('videos')->with('videos', $videos);
	}

	public function add_video_to_playlist(Request $request) {
		
	}

}

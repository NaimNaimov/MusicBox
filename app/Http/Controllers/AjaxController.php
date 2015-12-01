<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\GoogleYoutube;
use App\Room;
use DB;
use Auth;

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
		$user = Auth::user();
		$room = Room::where('slug', $request['slug'])->first();
		$response = array('success' => false);

		if ( !$room ) {
			echo json_encode($response);
			exit;
		}

		$is_public = $room->status === 'public';
		$is_owner = $room->user_id === $user->id; 
		// var_dump($room->user_id);
		// var_dump($user->id);
		if ($is_public || $is_owner) {
			$playlist = DB::table('playlist')->insert([
				'name' => $request['video_name'],
				'video_id' => $request['video_id'],
				'room_id' => $room->id

			]);

			if ($playlist) {
				$response['success'] = true;
			}
		}

		echo json_encode($response);
		exit;
	}

	public function remove_video_from_playlist(Request $request)
	{
		$user = Auth::user();
		$room = Room::where('slug', $request['slug'])->first();
		$response = array('success' => false);

		if ( !$room ) {
			echo json_encode($response);
			exit;
		}

		$is_owner = $room->user_id === $user->id; 
		
		if ($is_owner) {
			$playlist = DB::table('playlist')->where([
				'video_id' => $request['video_id'],
				'room_id' => $room->id
			])
			->delete();

			if ($playlist) {
				$response['success'] = true;
			}
		}

		echo json_encode($response);
		exit;

	}

	public function update_playlist(Request $request) {
		$user = Auth::user();
		$room = Room::where('slug', $request['slug'])->get();
		$room_playlists = DB::table('playlist')->where('room_id', $room->first()->id)->get();
		$playlist = array();

		$is_owner = $room->first()->user_id === $user->id; 

		if (!empty($room_playlists)) {
			foreach ($room_playlists as $item) {
				$playlist['items'][] = array(
					'videoId' => $item->video_id,
					'videoName' => $item->name,
					'id' => $item->id,
				);

				$playlist['user']['owner'] = $is_owner;
			}
		}

		return json_encode($playlist);
	}
}

<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Room;
use DB;
use Illuminate\Http\RedirectResponse;

class RoomController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_id = Auth::user()->id;
		$user_rooms = Room::where('user_id', $user_id)
			->where('status', 'private')
			->get();
		$user_public_rooms = Room::where('status', 'public')
			->where('user_id', $user_id )
			->get();
		$public_rooms = Room::where('status', 'public')->get();
		return view('room.index')
			->with(array(
				'user_rooms' => $user_rooms,
				'user_public_rooms' => $user_public_rooms,
				'public_rooms' => $public_rooms
			));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('room.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		// $all_rooms = DB::table('rooms')->lists('name');
		$input = Input::all();
		$user_id = Auth::user()->id;
		$validator = Validator::make($input, ['name' => 'required|unique:rooms,name']);
		$name = $input['name'];
		if (!$name || !$user_id) {
			return;
		}

		if ( $validator->passes() ) {
			$privacy = $input['status'];
			$slug = str_replace( array(' ', ';', ), '-', strtolower($name) );
			$room = new Room;

			$room->name = $name;
			$room->slug = $slug;
			$room->user_id = $user_id;
			$room->status = $privacy;
			$room->save();
			return redirect('/room');
		} 
		
		return back()->withInput()->withErrors($validator->messages());

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$room = Room::where('slug', $slug)->get();
		$playlists = DB::table('playlist')->where('room_id', $room->first()->id)->get();

		// var_dump($playlists);

		if ( $room->isEmpty() ) {
			abort(404);
		};

		$user_id = Auth::user()->id;
		$is_owner = false;
		if ($user_id === (int) $room->first()->user_id) {
			$is_owner = true;
		}

		return view('room.show')->with(array(
			'room' => $room,
			'playlist' => $playlists,
			'is_owner' => $is_owner
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	  $room = Room::findOrFail($id);
    	$room->delete();

    return redirect('/');
	}

}

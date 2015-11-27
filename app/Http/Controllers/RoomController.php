<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Room;
use DB;
// use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
class RoomController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		return view('welcome');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// $user = Auth::user();
		// var_dump($user);
		return view('room.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$all_rooms = DB::table('rooms')->lists('name');
		$input = Input::all();
		$user_id = Auth::user()->id;
		$name = $input['name'];
		$validator = Validator::make($input, ['name' => 'required']);

		if ( in_array($name, $all_rooms) ) {
			$errors['messages']['name'] = array('This name is already taken');
		}

		if (!$name || !$user_id) {
			return;
		}
		$privacy = $input['status'];

		$slug = str_replace( ' ', '-', strtolower($name) );

		$room = new Room;

		$room->name = $name;
		$room->slug = $slug;
		$room->user_id = $user_id;
		$room->status = $privacy;
		$room->save();

		if ( $validator->passes() && !$errors) {
			return redirect('/');
		} 

		
		var_dump( array_merge($errors,$validator->messages()) );
		exit;

		return back()->withInput()->withErrors($errors);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
		//
	}

}

<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Action;

class ActionsApiController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try{
			$statusCode = 200;
//			$response = [
//				'Age List'  => []
//			];

			$actions= Action::all();

			foreach($actions as $action){
//
				$response['Actions List'][] = [
					'id' => $action->id,
					'Action' => $action->action,

				];
			}
//			$response=$gender;

		}catch (Exception $e){
			$statusCode = 400;
		}finally{
			return Response::json($response, $statusCode);
		}


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
		$action=Action::find($id);
		//return $gender;
		if(count($action) > 0)
		{
			$statusCode = 200;
			$response = [
				'id' => $action->id,
				'Action' => $action->action,
			];
		}
		else
		{
			$response = [
				"error" => "Action doesn`t exist"
			];
			$statusCode = 404;

		}
		return response($response, $statusCode)->header('Content-Type', 'application/json');
	}




}

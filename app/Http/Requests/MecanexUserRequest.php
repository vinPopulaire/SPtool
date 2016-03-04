<?php namespace App\Http\Requests;

//use App\Http\Requests\Request;
use Illuminate\Support\Facades\Response;
//use Illuminate\Http\Response;

class MecanexUserRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if (Request::isMethod('post'))
		{
			return [
				//
				'username'=>'required|unique:mecanex_users',
				'name'=>'required|min:3',
				'surname'=>'required|min:3',
				'gender_id'=>'required|integer|min:1|max:2',
				'age_id'=>'required|integer|min:1|max:9',
				'occupation_id'=>'required|integer|min:1|max:18',
				'country_id'=>'required|integer|min:1|max:250',
				'education_id'=>'required|integer|min:1|max:5',
				'email'=>'required|email'
			];
		}
		if (Request::isMethod('put'))
		{
			return [
				'name'=>'min:3',
				'surname'=>'min:3',
				'gender_id'=>'integer|min:1|max:2',
				'age_id'=>'integer|min:1|max:9',
				'occupation_id'=>'integer|min:1|max:18',
				'country_id'=>'integer|min:1|max:250',
				'education_id'=>'integer|min:1|max:5',
				'email'=>'email'


			];
		}

	}

	public function response(array $errors)
	{

//		return  Response::make('Permission denied foo!', 403);
//		tried but didn't work
//		 return Response::json(array(
//				 array(
//				 'message' => 'Validation Failed',
//				 'errors' => $errors),
//			 		'404'
//			 )
//
//		 );
		$e =  array(
				 'error' => 'Validation Failed',
				 'errors' => $errors);
		return response($e, 400)->header('Content-Type', 'application/json');

	}
}

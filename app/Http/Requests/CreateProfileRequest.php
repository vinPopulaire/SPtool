<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateProfileRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *has the user permission to perform that action
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
		return [
			//
			'name'=>'required|min:2',
			'surname'=>'required|min:2',
			'gender_id'=>'required',
			'age_id'=>'required',
			'country_id'=>'required',
			'occupation_id'=>'required',
			'education_id'=>'required',
		];
	}

}

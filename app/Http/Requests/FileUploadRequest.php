<?php  namespace Softjob\Http\Requests;


class FileUploadRequest extends Request {

	public function rules()
	{
		
	}

	public function authorize()
	{
		return true;
	}
}
<?php  namespace Softjob\Http\Controllers;


use Illuminate\Contracts\Filesystem\Filesystem;

use Intervention\Image\ImageManagerStatic as Image;

class FilesController extends Controller{


	/**
	 * @var Filesystem
	 */
	protected $filesystem;

	function __construct(Filesystem $filesystem)
	{

		$this->filesystem = $filesystem;
	}

	public function getFile($filename)
	{

	}

	public function storeFile(FileUploadRequest $request)
	{

	}
}
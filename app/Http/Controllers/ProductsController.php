<?php namespace Softjob\Http\Controllers;

use Softjob\Contracts\Repositories\ProductRepoInterface;
use Softjob\Http\Requests;
use Softjob\Http\Requests\CreateProductRequest;

class ProductsController extends Controller {

	/**
	 * @var ProductRepoInterface
	 */
	private $productRepo;


	/**
	 * @param ProductRepoInterface $productRepo
	 */
	function __construct( ProductRepoInterface $productRepo )
	{
		$this->productRepo = $productRepo;
	}

	public function getProducts()
	{
		return $this->productRepo->getAllProducts();
	}

	public function getProductById( $productId )
	{

		$validator = \Validator::make([
			'id' => $productId
		], [
			'id' => 'required|numeric|exists:products,id'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid product id'
			], 404);
		}

		return $this->productRepo->getProductById($productId);
	}

	public function createProduct( CreateProductRequest $request )
	{
		$this->productRepo->createProduct($request->all());
	}
}

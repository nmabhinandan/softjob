<?php namespace Softjob\Repositories;


use Softjob\Contracts\Repositories\ProductRepoInterface;
use Softjob\Product;
use Softjob\Services\AuthService;
use Softjob\User;

class EloquentProductRepo implements ProductRepoInterface {

	/**
	 * @var Product
	 */
	private $model;

	/**
	 * @param Product $model
	 */
	function __construct( Product $model )
	{
		$this->model = $model;
	}


	/**
	 * Get all products
	 *
	 * @return mixed
	 */
	public function getAllProducts()
	{
		return $this->model->all();
	}

	/**
	 * Get product by product id
	 *
	 * @param $productId
	 *
	 * @return mixed
	 */
	public function getProductById( $productId )
	{
		return $this->model->with('issues.stage')->find($productId);
	}

	/**
	 * Create a new product
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function createProduct( $data )
	{
		$this->model->create([
			'name'            => $data['name'],
			'slug'            => $data['slug'],
			'description'     => $data['description'],
			'organization_id' => User::find(AuthService::$loggedInUser)->toArray()['organization_id']
		]);
	}
}
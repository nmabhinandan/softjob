<?php namespace Softjob\Contracts\Repositories;

interface ProductRepoInterface {

	/**
	 * Get all products
	 *
	 * @return mixed
	 */
	public function getAllProducts();

	/**
	 * Get product by product id
	 *
	 * @param $productId
	 *
	 * @return mixed
	 */
	public function getProductById( $productId );

	/**
	 * Create a new product
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function createProduct( $data );

}
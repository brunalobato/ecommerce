<?php

use \Hcode\model\Page;
use \Hcode\model\Product;

$app->get('/', function() {

	$products = Product::listAll();

	$page = new Page();

	$page->setTpl("index", [
		'products'=>Product::checkList($products)
	]);
	
});

?>
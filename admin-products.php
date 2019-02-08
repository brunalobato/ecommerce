<?php

use \Hcode\PageAdmin;
use \Hcode\model\User;
use \Hcode\model\Product;

$app->get("/admin/Products", function(){

    User::verifyLogin();

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
		$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
	
		if($search != '') {
			$pagination = Product::getPageSearch($search, $page);
	
		} else {
			$pagination = Product::getPage($page);
		}
	
		$pages = [];
	
		for ($x = 0; $x < $pagination['pages']; $x++)
		{
			array_push($pages, [
				'href'=>'/admin/products?'.http_build_query([
					'page'=>$search
				]),
				'text'=>$x+1
			]);
		}

    $products = Product::listAll();

    $page = new PageAdmin();

    $page->setTpl("products", [
        "products"=>$pagination['data'],
		"search"=>$search,
		"pages"=>[$pages]
    ]);
});

$app->get("/admin/products/create", function(){

    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("products-create");

});

$app->post("/admin/products/create", function(){

    User::verifyLogin();

    $product = new Product();

    $product->setData($_POST);

    $product->save();

    header("Location: /admin/products");
    exit;

});

$app->get("/admin/products/:idproduct", function($idproduct){

    User::verifyLogin();

    $product = new Product();

    $product->get((int)$idproduct);

    $page = new PageAdmin();

    $page->setTpl("products-create", [

        'product'=>$product->getValues()

    ]);

    $page->setTpl("products-create");

});

$app->get("/admin/products/:idproduct", function($idproduct){

    User::verifyLogin();

    $product = new Product();

    $product->get((int)$idproduct);

    $product->setData($_POST);

    $product->save();

    $product->setPhoto($_FILES["file"]);

    header('Location: /admin/products');
    exit;

});

    $app->get("/admin/products/:idproduct/delete", function($idproduct){

        User::verifyLogin();
    
        $product = new Product();
    
        $product->get((int)$idproduct);

        $product->delete();

        header('Location: /admin/products');
        exit;
  
});

?>
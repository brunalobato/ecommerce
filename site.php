<?php

use \Hcode\model\Page;

$app->get('/', function() {

	$page = new Page();

	$page->setTpl("index");
	
});

?>
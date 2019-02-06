<?php

use \Hcode\model\User;
use \Hcode\model\Cart;


function formatPrice($vlprice)
{
    if(!$vlprice > 0) $vlprice =0;

    return number_format($vlprice, 2, ",",".");
}

function checkLogin($inadmin = true){

    return User::checkLogin($inadmin);
}

function getUserName()
{
    $user = User::getFromSession();
    return $user->getperson();
}

function getCartNrtQtd()
{
    $cart = Cart::getFromSession();

    $totals = $cart->getProductsTotals();

    return $totals['nrqtd'];
}   

function getCartVlSubTotal()
{
    $cart = Cart::getFromSession();

    $totals = $cart->getProductsTotals();

    return formatPrice($totals['vlprice']);
}   

?>
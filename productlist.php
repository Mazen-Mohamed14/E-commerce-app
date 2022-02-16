<?php
require('classes.php');

$productsObject = new products();


if(isset($_POST['delete-product-btn'])) {
    if (isset($_POST['checkbox'])) {
        $delete = $_POST['checkbox'];
        foreach ($delete as $id) {
        $deleteProducts = $productsObject->deleteProducts($id);
        }

    }
}
$allProducts = $productsObject->getProducts();
    //print_r($products);
//print_r($allProducts);

//if(isset($_POST['delete-product-btn']))
//{
//    $cnt=array();
//    $cnt=count($_POST['checkbox']);
//    for($i=0;$i<$cnt;$i++)
//    {
//        $id=$_POST['checkbox'][$i];
//        print_r($id);
////        $deleteProducts = $productsObject->deleteProducts($id);
//
//    }
//}

include('index.html');
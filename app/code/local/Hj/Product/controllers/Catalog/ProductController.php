<?php
include_once("Mage/Adminhtml/controllers/Catalog/ProductController.php");

class Hj_Product_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
  public function indexAction()
  {
    echo "override controller";
  }
}
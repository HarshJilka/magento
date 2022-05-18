<?php

class Hj_Product_Block_Adminhtml_Product_Index extends Mage_Adminhtml_Block_Widget_Grid_Container{

    public function __construct()
    {
       /* echo "111";
        exit();*/
        parent::__construct();
        $this->_controller = "adminhtml_product_index";
        $this->_blockGroup = "product";
        $this->_headerText = Mage::helper('product')->__('product_Grid');
        $this->_addButtonLabel = Mage::helper('product')->__('Add_New');
    }

}
  
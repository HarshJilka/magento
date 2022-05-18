<?php

class Hj_Product_Block_Adminhtml_Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{

	protected function _construct()
	{
		$this->_blockGroup = 'product';
        $this->_controller = 'adminhtml_product';
	}
	
	/*protected function _prepareLayout
	{
		parent::_prepareLayout();
	}*/

	public function getHeaderText()
    {
        $model = Mage::registry('current_product');
        if ($model->getId()) 
        {
            return Mage::helper('product')->__("Edit product");
        } 
        else 
        {
            return Mage::helper('product')->__("Add new product");
        }
    }




}
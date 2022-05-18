<?php 
class Hj_Vendor_Block_Adminhtml_Vendor_Index extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'vendor';
		$this->_controller = 'adminhtml_vendor_index';
		$this->_headerText = Mage::helper('vendor')->__('Manage Vendors');
		$this->_addButtonLabel = Mage::helper('vendor')->__('Add New vendor');
		parent::__construct();
	}	
}
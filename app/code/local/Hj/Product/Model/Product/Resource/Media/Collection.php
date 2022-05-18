<?php

class Hj_Product_Model_Product_Resource_Media_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('productmedia/productmedia');
		
	}
}
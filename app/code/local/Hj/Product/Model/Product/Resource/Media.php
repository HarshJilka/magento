<?php

class Hj_Product_Model_Product_Resource_Media extends Mage_Core_Model_Resource_Db_Abstract
{
	public function _construct()
	{
		$this->_init('productmedia/productmedia','media_id');
		
	}
}
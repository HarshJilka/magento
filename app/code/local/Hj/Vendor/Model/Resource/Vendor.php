<?php 
class Hj_Vendor_Model_Resource_Vendor extends Mage_Eav_Model_Entity_Abstract
{
	public function _construct()
	{
		//$this->_init('vendor/vendor','vendor_id');
		$resource = Mage::getSingleton('core/resource');
        $this->setType('vendor');
        $this->setConnection(
            $resource->getConnection('vendor_read'),
            $resource->getConnection('vendor_write')
        );
	}
}
<?php
class Hj_Process_Model_Resource_Process_Entry_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('process/process_entry');
	}
}
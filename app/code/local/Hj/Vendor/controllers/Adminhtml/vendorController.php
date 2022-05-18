<?php
class Hj_Vendor_Adminhtml_vendorController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()->_setActiveMenu('vendor/vendor');
		return $this;
	}

	public function indexAction()
	{
	// 	echo '110';
		$this->_initAction();
		// $this->getLayout()->getBlock('content')->append();
		$this->_addContent($this->getLayout()->createBlock('vendor/adminhtml_vendor_index'));
		$this->renderLayout();
	}

	public function editAction()
	{
		$vendorId = $this->getRequest()->getParam('id');
		$vendorModel = Mage::getModel('vendor/vendor')->load($vendorId);

		if ($vendorModel->getId() || $vendorId == 0) {
			Mage::register('vendor_data', $vendorModel);
			$this->loadLayout();
			$this->_setActiveMenu('vendor/vendor');
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('vendor/adminhtml_vendor_index_edit'));
			$this->renderLayout();
		} else {
			$this->_redirect('*/*/');
		}
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function saveAction()
	{
		$postData = $this->getRequest()->getPost();
		$model = Mage::getModel('vendor/vendor');
		$date = date('Y-m-d H:i:s');
		$id = $this->getRequest()->getParam('id');
		if ($id) 
		{
			unset($postData['form_key']);
			foreach($postData as $key => $value)
			{
				$dataName = $model->getResource()->getReadConnection()->fetchAll("SELECT * FROM `eav_attribute` WHERE `attribute_code` = '$key' AND `entity_type_id` = 12");
				$attributeId = $dataName['0']['attribute_id'];
				$backendType = $dataName['0']['backend_type'];
				$dbData = $model->getResource()->getReadConnection()->fetchRow("SELECT * FROM `vendor_entity_{$backendType}` WHERE `entity_id` = {$id} AND `attribute_id` = {$attributeId}");
				$valueId = $dbData['value_id'];
				$attributes = $dbData['attribute_id'];
				$result = $model->getResource()->getReadConnection()->fetchAll("UPDATE `vendor_entity_{$backendType}` SET value = '{$value}' WHERE value_id = $valueId AND attribute_id = $attributes");
				$model->save();
			}
		}
		else
		{
			$model->setData($postData);
			$model->setcreatedDate($date);
			$model->save();
		}
		$this->_redirect('*/*/');
	}

	public function deleteAction()
	{
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$vendorModel = Mage::getModel('vendor/vendor');

				$vendorModel->setId($this->getRequest()->getParam('id'))
				->delete();

				$this->_redirect('*/*/');
			} catch (Exception $e) {
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

}
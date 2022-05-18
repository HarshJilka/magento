<?php
class Hj_Salesman_Adminhtml_salesmanController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()->_setActiveMenu('salesman/salesman');
		return $this;
	}

	public function indexAction()
	{
		$this->_initAction();
		// $this->getLayout()->getBlock('content')->append();
		$this->_addContent($this->getLayout()->createBlock('salesman/adminhtml_salesman_index'));
		$this->renderLayout();
	}

	public function editAction()
	{
		$salesmanId = $this->getRequest()->getParam('id');
		$salesmanModel = Mage::getModel('salesman/salesman')->load($salesmanId);

		if ($salesmanModel->getId() || $salesmanId == 0) {
			Mage::register('salesman_data', $salesmanModel);
			$this->loadLayout();
			$this->_setActiveMenu('salesman/salesman');
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('salesman/adminhtml_salesman_index_edit'));
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
		if ( $this->getRequest()->getPost() ) {
			$id = $this->getRequest()->getParam('id');
			$postData = $this->getRequest()->getPost();
			$model = Mage::getModel('salesman/salesman');
			$date = date('Y-m-d H:i:s');
			if ($id) {
				$model->setData($postData)->setId($this->getRequest()->getParam('id'))->setupdatedDate($date);
			}else{
				$model->setData($postData);
				$model->setcreatedDate($date);
			}
			$model->save();
		}
		$this->_redirect('*/*/');
	}

	public function deleteAction()
	{
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$salesmanModel = Mage::getModel('salesman/salesman');

				$salesmanModel->setId($this->getRequest()->getParam('id'))
				->delete();

				$this->_redirect('*/*/');
			} catch (Exception $e) {
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
}
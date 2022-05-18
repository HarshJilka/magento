<?php 
class Hj_Process_Adminhtml_ProcessEntryController extends Mage_Adminhtml_Controller_Action
{
	public function _initAction()
	{
		$this->loadLayout()->_setActiveMenu('process/process');
		return $this;
	}

	public function indexAction()
	{
		$this->_initAction();
		// $this->_addContent($this->getLayout()->createBlock('process/adminhtml_processentry'));
		$this->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}



	public function editAction()
	{
		$this->loadLayout();
        $model = Mage::getModel('process/process_entry');
        if ($this->getRequest()->getParam('id')) 
        {
            $id = $this->getRequest()->getParam('id');
            $model->load($id);
            if(!$model->getId()) 
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('process')->__('Not Exist'));
                $this->_redirect('*/*/index');
                return;
            }
        } 
        Mage::register('process_data', $model);  

        $this->_addLeft($this->getLayout()->createBlock('process/adminhtml_process_entry_edit_tabs'));
        $this->renderLayout();
	}

	public function saveAction()
	{
		if ( $this->getRequest()->getPost() ) {
			$id = $this->getRequest()->getParam('id');
			$postData = $this->getRequest()->getPost();
			$model = Mage::getModel('process/process_entry');
			$date = date('Y-m-d H:i:s');
			if ($id) {
				$model->setData($postData)->setId($this->getRequest()->getParam('id'));
			}else{
				$model->setData($postData);
				$model->setcreatedDate($date);
				$model->setstartTime($date);
			}
			$model->save();
		}
		$this->_redirect('*/*/');
	}

	public function deleteAction()
	{
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$processModel = Mage::getModel('process/process_entry');

				$processModel->setId($this->getRequest()->getParam('id'))
				->delete();

				$this->_redirect('*/*/');
			} catch (Exception $e) {
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	public function massDeleteAction() 
	{
	    $requestIds = $this->getRequest()->getParam('massDelete');
	    if(!is_array($requestIds)) {
	        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('process')->__('Please select reqeust(s)'));
	    } else {
	        try {
	            foreach ($requestIds as $requestId) {
	                $RequestData = Mage::getModel('process/process_entry')->load($requestId);                    
	                $RequestData->delete();                    
	            }
	            Mage::getSingleton('adminhtml/session')->addSuccess(
	                Mage::helper('process')->__(
	                    'Total of %d record(s) were successfully deleted', count($requestIds)
	                )
	            );
	        } catch (Exception $e) {
	            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	        }
	    }
	    $this->_redirect('*/*/');
	}

	public function massDeleteProcessAction() 
      {

          $sampleIds = $this->getRequest()->getParam('massDelete');
          if(!is_array($sampleIds))
          {
              Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
          } 
          else 
          {
              try
              {
                  $count = 0;
                  foreach ($sampleIds as $sampleId)
                  {
                    $entryModel = Mage::getModel('process/process_entry')->load($sampleId);
                    $select = $entryModel->getCollection()
                        ->getSelect()
                        ->reset(Zend_Db_Select::COLUMNS)
                        ->columns(['entry_id'])
                        ->where('process_id = ?', $entryModel->getProcessId());
                        $entryIds = $entryModel->getResource()->getReadConnection()->fetchAll($select);
                        foreach ($entryIds as $entryId) 
                        {
                            $entry = Mage::getModel('process/process_entry')->load($entryId['entry_id']);
                            $entry->delete();
                            $count++;
                        }
                  }
                  Mage::getSingleton('adminhtml/session')->addSuccess(
                  Mage::helper('adminhtml')->__('Total of '.$count.' record(s) were successfully deleted', count($count)));
              } 
              catch (Exception $e)
              {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
              }
          }
              $this->_redirect('*/*/');
      }

}
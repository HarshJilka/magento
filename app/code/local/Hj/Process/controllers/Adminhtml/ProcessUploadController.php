<?php 
class Hj_Process_Adminhtml_ProcessUploadController extends Mage_Adminhtml_Controller_Action
{
    
    public function uploadfileAction()
    {
        $processId = $this->getRequest()->getParam('id');
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        $process = Mage::getModel('process/process')
        ->setStoreId($this->getRequest()->getParam('store', 0))
        ->load($processId);

        Mage::register('current_process_media', $process);

        if (!$processId) 
        {
            $this->_getSession()->addError(Mage::helper('process')->__('This process no longer exists'));
            $this->_redirect('*/*/');
            return;
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    public function uploadAction()
    {
        $processId = $this->getRequest()->getParam('id');
        $model = Mage::getModel('process/process');
        if($model->load($processId))
        {
            $fileName = $model->uploadFile();
        }
        if($fileName)
        {
            $model->setData('file_name',$fileName);
            $model->save();          
        }
        $this->_redirect('process/adminhtml_process/index');
    }

    public function saveAction()
    {
        $this->_forward('upload');
    }

    /*public function exportAction()
    {
        try 
        {
            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('process/process')->load($id);
            $csv = $model->downloadSample()['value'];

            $this->_prepareDownloadResponse($model->getFileName(), $csv);
            $this->_getSession()->addSuccess($this->__("File Downloaded."));
        }
        catch (Exception $e) 
        {
             
        }
    }*/


    public function exportAction()
    {
        try {
            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('process/process')->load($id);
            $csv = $model->downloadSample();
            $this->_prepareDownloadResponse($model->getFileName(), $csv);
            $this->_getSession()->addSuccess($this->__("File Downloaded."));
            $this->_redirect('process/adminhtml_process/index');
        }
        catch (Exception $e) {
            $this->_getSession()->addError($this->__($e->getMessage()));
            $this->_redirect('process/adminhtml_process/index');
        }
    }

    public function verifyAction()
    {
        try 
        {
            $Id = $this->getRequest()->getParam('id');
            $process = Mage::getModel('process/process');
            if ($process->load($Id))
            {
                $model = Mage::getModel($process->getRequestModel());
                $filename = $model->setProcess($process)->verify();
            }
            $this->_getSession()->addSuccess(Mage::helper('process')->__("File Verified successfully."));
        }
        catch (Exception $e) 
        {
            $this->_getSession()->addError(Mage::helper('process')->__($e->getMessage()));
        }
        $this->_redirect('process/adminhtml_process/index');
    }

    public function executeAction()
    {
        try{
            $this->loadLayout();
            $processId = $this->getRequest()->getParam('id');
            $process = Mage::getModel('process/process')->load($processId);
            if (!$process) {
                throw new Exception("No data loaded.", 1);
            }
            if (!$this->_prepareProcessEntryVariables($process)) {
                $this->_redirect('process/adminhtml_process/index');                
            }
            $this->renderLayout();
        }
        catch (Exception $e) {
            $this->_getSession()->addError(Mage::helper('process')->__($e->getMessage()));
            $this->_redirect('process/adminhtml_process/index');
        }
    }

    public function _prepareProcessEntryVariables($process)
    {
        $sessionVariables = [
                'processId' =>$process->getId(),
                'totalCount' => 0,
                'perRequestCount' => 0, 
                'totalRequest' => 0,
                'currentRequest' =>0,
        ];

        $processEntry = Mage::getModel('process/process_entry');
        $select = $processEntry->getCollection()
                    ->getSelect()
                    ->reset(Zend_Db_Select::COLUMNS)
                    ->columns(['count(entry_id)'])
                    ->where('process_id = ?', $process->getData('process_id'))
                    ->where('start_time IS NULL');
        $entryData = $processEntry->getResource()->getReadConnection()->fetchOne($select);
        if (!$entryData) {
            $this->_getSession()->addSuccess(Mage::helper('process')->__("All records has been procced, No pending record found."));
            return false;
        }
        $sessionVariables['totalCount'] = $entryData;
        $sessionVariables['perRequestCount'] = $process->getData('per_request_count');
        $sessionVariables['totalRequest'] = ceil($sessionVariables['totalCount'] / $sessionVariables['perRequestCount']);
        $sessionVariables['currentRequest'] = 1;
        Mage::getSingleton('core/session')->setProcessEntryVariables($sessionVariables);
        return true;
    }

    public function processEntryAction()
    {
        try {
            $processEntryVariables = Mage::getSingleton('core/session')->getProcessEntryVariables();
            $processId = $processEntryVariables['processId'];

            if(!$processId)
            {
                throw new Exception("No process found.", 1);
            }

            $process = Mage::getModel('process/process')->load($processId);
            if (!$process) {
                throw new Exception("No data loaded.", 1);
            }
            $requestModel = Mage::getModel($process->getRequestModel());
            
            if(!$requestModel)
            {
                throw new Exception("Request model not found", 1);
            }
            
            $requestModel->setProcess($process)->execute();
            sleep(2);
            $reload = false;
            if ($processEntryVariables['currentRequest'] == $processEntryVariables['totalRequest']) {
                $reload = true;
            }
            $processEntryVariables['currentRequest'] += 1;

            Mage::getSingleton('core/session')->setProcessEntryVariables($processEntryVariables);

            $response = [
            'status' => 'success',
            'reload' => $reload,
            'sessionVariables' => $processEntryVariables,
            'message' => $process->getData()
            ];

            // if ($sessionProcessEntry['currentRequest'] > $sessionProcessEntry['totalRequest'])
            // {
            //    throw new Exception("No Request Available");
            // }

            // $processModel = $sessionProcessEntry['processId'];
            // $requestModelName = $processModel->getData('request_model');
            // $requestModel = Mage::getModel($requestModelName);
            
            // if(!$requestModel)
            // {
            //     throw new Exception("Request model not found", 1);
            // }
            
            // $requestModel->setProcess($process)->execute();
            // $reload = false;
            // sleep(2);
            // if($sessionProcessEntry['currentRequest']  == $sessionProcessEntry['totalRequest'])
            // {
            //     $reload = true; 
            // }
            // $sessionProcessEntry['currentRequest'] += 1;
            // Mage::getSingleton('core/session')->setProcessEntryVariable($sessionProcessEntry);
            // // Mage::log($sessionProcessEntry,null,'se.log',true);
            // $response = [
            // 'status' => 'success',
            // 'reload' => $reload,
            // 'sessionVariables' => $sessionProcessEntry,
            // 'message' => "Processing :".($sessionProcessEntry['currentRequest'] - 1). "/" .($sessionProcessEntry['totalRequest'])
            // ];
            // Mage::log($response,null,'ab.log',true);
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));

        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $response = [
            'status' => 'failure',
            'reload' => true,
            'message' => $e->getMessage()
            ];
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        }
    }

}   

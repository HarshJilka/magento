<?php
class Hj_Product_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		/*echo "Hello";*/
		$this->loadLayout();
		/*$this->_addContent($this->getLayout()->createBlock('product/adminhtml_product_index'));*/
		$this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('product/adminhtml_product_index'));
        // Mage::dispatchEvent('dispatch_event_testing', array('product' => $model));
        /*$helper = Mage::helper('catalog/data');
        echo '<pre>';
        print_r($helper);
        die();
		*/
        $this->renderLayout();

	}

	public function editAction()
    {
       $this->loadLayout();
       $id =  $this->getRequest()->getParam('id');   //echo $id; exit();
       $model = Mage::getModel('product/product');

        if ($id) 
        {
            $model->load($id);                   //print_r($model);    exit();
            if(!$model->getId()) 
            {
                $this->_redirect('*/*/index');
                return;
            }
        }

        $this->_title($model->getId() ? $this->__('Edit product') : $this->__('New product'));
        Mage::register('current_product', $model);

        $this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('product/adminhtml_product_edit', 'productEdit'));
        $this->renderLayout();
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
            $model = Mage::getModel('product/product');
            $date = date('Y-m-d H:i:s');
            if ($id) {
                $model->setData($postData)->setId($this->getRequest()->getParam('id'))->setupdatedDate($date);
            }
            else{
                $model->setData($postData);
                $model->setcreatedDate($date);
            }
            $model->save();
        }
        $this->_redirect('product/adminhtml_product/index');
    }

    public function deleteAction()
   {
       if($id = $this->getRequest()->getParam('id')) 
       {
           try 
           {
               Mage::getModel('product/product')->load($id)->delete();
           } 
           catch (Exception $e) 
           {
               $this->_redirect('*//*///edit', array('id' => $id));
           }
       }
     $this->_redirect('product/adminhtml_product/index');
   }

}
<?php

class Hj_Product_Block_Adminhtml_Product_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{

	protected function _prepareForm()
	{
		$helper = Mage::helper('product');
        $model = Mage::registry('current_product');

        // print_r($model->getData());  exit();

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array(
                'id' => $this->getRequest()->getParam('id')
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $this->setForm($form);

        $fieldset = $form->addFieldset('product_form', array('legend' => $helper->__('product info')));
        
        $fieldset->addField('name', 'text', array(
            'label' => $helper->__('Name'),
            'required' => true,
            'name' => 'name'
        ));

         $fieldset->addField('sku', 'text', array(
            'label' => $helper->__('sku'),
            'required' => true,
            'name' => 'sku'
        ));

          $fieldset->addField('price', 'text', array(
            'label' => $helper->__('price'),
            'required' => true,
            'name' => 'price'
        ));

           $fieldset->addField('quantity', 'text', array(
            'label' => $helper->__('quantity'),
            'required' => true,
            'name' => 'quantity'
        ));

            /*$fieldset->addField('status', 'text', array(
            'label' => $helper->__('status'),
            'required' => true,
            'name' => 'status'
        ));*/

            $fieldset->addField('status', 'select', array(
                'name'      => 'status',
                'label'     => Mage::helper('adminhtml')->__('Status'),
                'id'        => 'status',
                'title'     => Mage::helper('adminhtml')->__('Status'),
                'class'     => 'input-select',
                'style'        => 'width: 80px',
                'options'    => array('1' => Mage::helper('product')->__('Active'), '2' => Mage::helper('product')->__('Inactive')),
        ));

        $form->setUseContainer(true);

        $form->setValues($model->getData());
        return parent::_prepareForm();
    }
}


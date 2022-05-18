<?php
class Hj_Process_Block_Adminhtml_Process_Edit_Tab_File extends Mage_Adminhtml_Block_Widget_Form
{

  protected function _prepareForm()
  {
    $form = new Varien_Data_Form();
    $this->setForm($form);
    $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('process')->__('information')));

    $id = $this->getRequest()->getParam('id');
    $model = Mage::getModel('process/process')->load($id);

    $fieldset->addField('fileName', 'file', array(
            'label'     => Mage::helper('process')->__('CSV'),
            'class'     => 'disable',
            'name'      => 'fileName',
            ));

    if ( Mage::registry('process_data') ) {
      $form->setValues(Mage::registry('process_data')->getData());
    }
    return parent::_prepareForm();
  }
}
<?php
class Hj_Process_Block_Adminhtml_Process_Entry_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function getProcessNames()
  {
    $model = Mage::getModel('process/process');
    $select = $model->getCollection()
              ->getSelect()
              ->reset(Zend_Db_Select::COLUMNS)
              ->columns(['value' => 'process_id','label' => 'name'])
              ->order('name','ASC');
    $groupOptions = $model->getResource()->getReadConnection()->fetchAll($select);
    foreach ($groupOptions as $data)
    {
        $label = $data['value']." => ".$data['label'];
        $array = array('value'=>$data['value'] ,'label'=>$label);
        $finalarray[]=$array;
    }
    return $finalarray;
  }

  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('process')->__('information')));

      $id = $this->getRequest()->getParam('id');
      $model = Mage::getModel('process/process_entry')->load($id);

      $fieldset->addField('process_id', 'select', array(
          'label'     => Mage::helper('process')->__('Process Name'),          
          'name'      => 'process_id',
          'values' => $this->getProcessNames(),
      ));

      $fieldset->addField('data', 'text', array(
          'label'     => Mage::helper('process')->__('Data'),          
          'name'      => 'data',
          'value' => $model->getData('data'),
      ));

      $fieldset->addField('identifier', 'text', array(
          'label'     => Mage::helper('process')->__('Identifier'),          
          'name'      => 'identifier',
          'value' => $model->getData('identifier'),
      ));

      if ( Mage::registry('process_data') ) {
          $form->setValues(Mage::registry('process_data')->getData());
      }
      return parent::_prepareForm();
  }
}
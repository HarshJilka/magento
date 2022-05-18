<?php
class Hj_Process_Block_Adminhtml_Process_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function getGroupedOptions()
  {
    $model = Mage::getModel('process/process_group');
    $select = $model->getCollection()
              ->getSelect()
              ->reset(Zend_Db_Select::COLUMNS)
              ->columns(['value' => 'process_group_id','label' => 'name'])
              ->order('name','ASC');
    $groupOptions = $model->getResource()->getReadConnection()->fetchAll($select);
    if ($groupOptions) {
      return $groupOptions;
    }
    return [];
  }

  protected function _prepareForm()
  {
    $form = new Varien_Data_Form();
    $this->setForm($form);
    $fieldset = $form->addFieldset('abc', array('legend'=>Mage::helper('process')->__('information')));

    $id = $this->getRequest()->getParam('id');
    $model = Mage::getModel('process/process')->load($id);

    $fieldset->addField('group_id', 'select', array(
      'label'     => Mage::helper('process')->__('Group Name'),          
      'name'      => 'group_id',
      'values' => $this->getGroupedOptions(),
    ));

    $fieldset->addField('type_id','select',array(
      'label' => Mage::helper('process')->__('Type Id'),
      'name' => 'type_id',
      'values' => [
          ['value' => Hj_Process_Model_Process::TYPE_ID_IMPORT, 'label' =>Mage::helper('process')->__('Import')],
          ['value' => Hj_Process_Model_Process::TYPE_ID_EXPORT, 'label' =>Mage::helper('process')->__('Export')],
          ['value' => Hj_Process_Model_Process::TYPE_ID_CRON, 'label' =>Mage::helper('process')->__('Cron')],
        ]
    ));

   //  $fieldset->addField('type_id', 'select', array(
   //   'label' => Mage::helper('process')->__('Type Id'),
   //   'name' => 'type_id',
   //   'values' => array(
   //     array(
   //       'value' => 1,
   //       'label' => Mage::helper('process')->__('Import'),
   //     ),

   //     array(
   //       'value' => 2,
   //       'label' => Mage::helper('process')->__('Export'),
   //     ),
   //     array(
   //       'value' => 3,
   //       'label' => Mage::helper('process')->__('Cron'),
   //     ),
   //   ),
   // ));

    $fieldset->addField('name', 'text', array(
      'label'     => Mage::helper('process')->__('Name'),          
      'name'      => 'name',
      'value' => $model->getData('name'),
    ));

    $fieldset->addField('per_request_count', 'text', array(
      'label'     => Mage::helper('process')->__('Per Request Count'),          
      'name'      => 'per_request_count',
      'value' => $model->getData('per_request_count'),
    ));

    $fieldset->addField('request_interval', 'text', array(
      'label'     => Mage::helper('process')->__('Request Interval'),          
      'name'      => 'request_interval',
      'value' => $model->getData('request_interval'),
    ));

    $fieldset->addField('request_model', 'text', array(
      'label'     => Mage::helper('process')->__('Request Model'),          
      'name'      => 'request_model',
      'value' => $model->getData('request_model'),
    ));

    $fieldset->addField('file_name', 'text', array(
      'label'     => Mage::helper('process')->__('File Name'),          
      'name'      => 'file_name',
      'value' => $model->getData('file_name'),
    ));

    if ( Mage::registry('process_data') ) {
      $form->setValues(Mage::registry('process_data')->getData());
    }
    return parent::_prepareForm();
  }
}
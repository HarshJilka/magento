<?php
class Hj_Process_Block_Adminhtml_Process_Column_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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
      $model = Mage::getModel('process/process_column')->load($id);

      $fieldset->addField('process_id', 'select', array(
          'label'     => Mage::helper('process')->__('Process Name'),          
          'name'      => 'process_id',
          'values' => $this->getProcessNames(),
      ));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('process')->__('Column Name'),          
          'name'      => 'name',
          'value' => $model->getData('name'),
      ));

      $fieldset->addField('required', 'select', array(
        'label' => Mage::helper('process')->__('Required'),
        'name' => 'required',
        'values' => [
          ['value' => Hj_Process_Model_Process::YES, 'label' =>Mage::helper('process')->__('Yes')],
          ['value' => Hj_Process_Model_Process::NO, 'label' =>Mage::helper('process')->__('No')],
        ]
      ));

      // $fieldset->addField('required', 'select', array(
      //    'label' => Mage::helper('process')->__('Required'),
      //    'name' => 'required',
      //    'values' => array(
      //                    array(
      //                    'value' => 1,
      //                    'label' => Mage::helper('process')->__('Yes'),
      //                    ),

      //                   array(
      //                    'value' => 2,
      //                    'label' => Mage::helper('process')->__('No'),
      //                    ),
      //               ),
      //   ));

      $fieldset->addField('casting_type', 'select', array(
         'label' => Mage::helper('process')->__('Casting Type'),
         'name' => 'casting_type',
         'values' => [
            ['value' => Hj_Process_Model_Process::VARCHAR, 'label' =>Mage::helper('process')->__('Varchar')],
            ['value' => Hj_Process_Model_Process::INT, 'label' =>Mage::helper('process')->__('Int')],
            ['value' => Hj_Process_Model_Process::DECIMAL, 'label' =>Mage::helper('process')->__('Decimal')],
          ]
        ));

      $fieldset->addField('exception', 'select', array(
         'label' => Mage::helper('process')->__('Exception'),
         'name' => 'exception',
         'values' => [
          ['value' => Hj_Process_Model_Process::YES, 'label' =>Mage::helper('process')->__('Yes')],
          ['value' => Hj_Process_Model_Process::NO, 'label' =>Mage::helper('process')->__('No')],
        ]
        ));

      $fieldset->addField('sample_value', 'text', array(
          'label'     => Mage::helper('process')->__('Sample Value'),          
          'name'      => 'sample_value',
          'value' => $model->getData('sample_value'),
      ));
      
      if ( Mage::registry('process_data') ) {
          $form->setValues(Mage::registry('process_data')->getData());
      }
      return parent::_prepareForm();
  }
}
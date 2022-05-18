<?php
class Hj_Process_Block_Adminhtml_Process_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('edit_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('process')->__('Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section1', array(
          'label'     => Mage::helper('process')->__('Process Information'),         
          'content'   => $this->getLayout()->createBlock('process/adminhtml_process_edit_tab_form')->toHtml(),
      ));

      // $this->addTab('form_section2', array(
      //     'label'     => Mage::helper('process')->__('File Upload'),         
      //     'content'   => $this->getLayout()->createBlock('process/adminhtml_process_edit_tab_file')->toHtml(),
      // ));

      return parent::_beforeToHtml();
  }
}
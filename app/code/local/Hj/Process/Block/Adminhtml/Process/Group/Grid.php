<?php
class Hj_Process_Block_Adminhtml_Process_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _prepareMassaction()
	{
	    $this->setMassactionIdField('id');
	    $this->getMassactionBlock()->setFormFieldName('massDelete');

	    $this->getMassactionBlock()->addItem('delete', array(
	         'label'    => Mage::helper('process')->__('Delete'),
	         'url'      => $this->getUrl('*/*/massDelete'),
	         'confirm'  => Mage::helper('process')->__('Are you sure?')
	    ));
	    return $this;
	}

	protected function _prepareCollection()
	{
	    $collection = Mage::getModel('process/process_group')->getCollection();
	    $this->setCollection($collection);
	    return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
	    $this->addColumn('process_group_id', array(
	        'header' => Mage::helper('process')->__('Process Group Id'),
	        'align' => 'right',
	        'index' => 'process_group_id',
	    ));
	    $this->addColumn('name', array(
	        'header' => Mage::helper('process')->__('Name'),
	        'align' => 'right',
	        'index' => 'name',
	    ));

	    return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
	    return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
	}

}
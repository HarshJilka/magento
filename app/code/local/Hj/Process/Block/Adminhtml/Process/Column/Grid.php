<?php
class Hj_Process_Block_Adminhtml_Process_Column_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	const DEFAULT_BROWSE_BUTTON_ID_SUFFIX = 'browse';

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

	    $collection = Mage::getModel('process/process_column')->getCollection();
	    foreach ($collection->getItems() as $data) 
	    {
	    	$data->process_id = Mage::getModel('process/process')->load($data->process_id)->name;
	    }
	    $this->setCollection($collection);
	    return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('column_id', array(
				'header' => Mage::helper('process')->__('Column Id'),
				'index' => 'column_id',
		));

	    $this->addColumn('process_id', array(
				'header' => Mage::helper('process')->__('Process Name'),
				'index' => 'process_id',
		));

	 	$this->addColumn('name', array(
	        'header' => Mage::helper('process')->__('Name'),
	        'index' => 'name',
	    ));

	  	$this->addColumn('required', array(
				'header' => Mage::helper('process')->__('Required'),
				'index' => 'required',
				'type'      => 'options',
	            'options'   => array(
	                1 => Mage::helper('process')->__('Yes'),
	                2 => Mage::helper('process')->__('No'),
	            ),
		));

	    $this->addColumn('casting_type', array(
				'header' => Mage::helper('process')->__('Casting Type'),
				'index' => 'casting_type',
				'type'      => 'options',
	            'options'   => array(
	                1 => Mage::helper('process')->__('Decimal'),
	                2 => Mage::helper('process')->__('Int'),
	                3 => Mage::helper('process')->__('Varchar'),
	            ),
		));

	    $this->addColumn('exception', array(
				'header' => Mage::helper('process')->__('Exception'),
				'index' => 'exception',
				'type'      => 'options',
	            'options'   => array(
	                1 => Mage::helper('process')->__('Yes'),
	                2 => Mage::helper('process')->__('No'),
	            ),
		));

	    return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
	    return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
	}

}
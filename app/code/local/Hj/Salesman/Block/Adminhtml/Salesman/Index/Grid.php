<?php
class Hj_Salesman_Block_Adminhtml_Salesman_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
        $this->setId('salesmanGrid');
        $this->setDefaultSort('salesmanId');
        $this->setDefaultDir('asc');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
	    $collection = Mage::getModel('salesman/salesman')->getCollection();
	    $this->setCollection($collection);
	    return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
	    $this->addColumn('salesmanId', array(
	        'header' => Mage::helper('salesman')->__('Salesman Id'),
	        'align' => 'right',
	        'index' => 'salesmanId',
	    ));

	    $this->addColumn('first_name', array(
	        'header' => Mage::helper('salesman')->__('First Name'),
	        'index' => 'first_name',
	    ));

	    $this->addColumn('last_name', array(
	        'header' => Mage::helper('salesman')->__('Last Name'),
	        'index' => 'last_name',
	    ));

		$this->addColumn('email', array(
	        'header' => Mage::helper('salesman')->__('Email'),
	        'index' => 'email',
	    ));

	    $this->addColumn('mobile', array(
	        'header' => Mage::helper('salesman')->__('Mobile Number'),
	        'index' => 'mobile',
	    ));

	    $this->addColumn('percentage', array(
	        'header' => Mage::helper('salesman')->__('Discount'),
	        'index' => 'percentage',
	    ));

	    $this->addColumn('status', array(
	        'header' => Mage::helper('salesman')->__('Status'),
	        'index' => 'status',
	    ));

	    $this->addColumn('created_date', array(
	        'header' => Mage::helper('salesman')->__('Created Date'),
	        'index' => 'created_date',
	    ));

	    $this->addColumn('updated_date', array(
	        'header' => Mage::helper('salesman')->__('Updated Date'),
	        'index' => 'updated_date',
	    ));

	    return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
	    return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
	}

}
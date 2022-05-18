<?php
class Hj_Category_Block_Adminhtml_Category_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
        $this->setId('categoryGrid');
        $this->setDefaultSort('path');
        $this->setDefaultDir('asc');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
	    $collection = Mage::getModel('category/category')->getCollection();
	    foreach($collection->getItems() as $col)
	    {
	    	$col->name = $col->getPath();
	    }
	    $this->setCollection($collection);
	    return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
	    $this->addColumn('category_id', array(
	        'header' => Mage::helper('category')->__('Category Id'),
	        'align' => 'right',
	        'index' => 'category_id',
	    ));

	    $this->addColumn('name', array(
	        'header' => Mage::helper('category')->__('Name'),
	        'index' => 'name',
	    ));

	 //    $this->addColumn('base', array(
	 //        'header' => Mage::helper('category')->__('Base'),
	 //        'index' => 'base',
	 //    ));

		// $this->addColumn('thumbnail', array(
	 //        'header' => Mage::helper('category')->__('Thumbnail'),
	 //        'index' => 'thumbnail',
	 //    ));

	 //    $this->addColumn('small', array(
	 //        'header' => Mage::helper('category')->__('Small'),
	 //        'index' => 'small',
	 //    ));

	    $this->addColumn('status', array(
	        'header' => Mage::helper('category')->__('Status'),
	        'index' => 'status',
	    ));

	    $this->addColumn('path', array(
	        'header' => Mage::helper('category')->__('Path'),
	        'index' => 'path',
	    ));

	    $this->addColumn('parentid', array(
	        'header' => Mage::helper('category')->__('Parent Id'),
	        'index' => 'parentid',
	    ));

	    $this->addColumn('created_date', array(
	        'header' => Mage::helper('category')->__('Created Date'),
	        'index' => 'created_date',
	    ));

	    $this->addColumn('updated_date', array(
	        'header' => Mage::helper('category')->__('Updated Date'),
	        'index' => 'updated_date',
	    ));

        $this->addColumn('action',array(
        		'header'    =>  Mage::helper('category')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('category')->__('Gallery'),
                        'url'       => array('base'=> '*/*/gallery'),
                        'field'     => 'id')
                   )));

	    return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
	    return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
	}

}
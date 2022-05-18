<?php

class Hj_Product_Block_Adminhtml_Product_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('product_id');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
      $collection = Mage::getModel('product/product')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('product_id', array(
          'header'    => Mage::helper('product')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'product_id',
        ));   

        $this->addColumn('name', array(
          'header'    => Mage::helper('product')->__('Name'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'name',
        ));   

        $this->addColumn('sku', array(
          'header'    => Mage::helper('product')->__('Sku'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'sku',
        ));

         $this->addColumn('price', array(
          'header'    => Mage::helper('product')->__('Price'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'price',
        ));

          $this->addColumn('quantity', array(
          'header'    => Mage::helper('product')->__('Quantity'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'quantity',
        ));

           $this->addColumn('status', array(
          'header'    => Mage::helper('product')->__('Status'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'status',
        ));

            $this->addColumn('created_date', array(
          'header'    => Mage::helper('product')->__('created_date'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'created_date',
        ));

            $this->addColumn('updated_date', array(
          'header'    => Mage::helper('product')->__('updated_date'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'updated_date',
        ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('product')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('product')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

        return parent::_prepareColumns();
    }   

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('product_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('product')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('product')->__('Are you sure?')
        ));
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }  
}
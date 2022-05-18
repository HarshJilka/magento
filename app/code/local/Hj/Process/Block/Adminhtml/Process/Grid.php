<?php
class Hj_Process_Block_Adminhtml_Process_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _prepareCollection()
	{
	    $collection = Mage::getModel('process/process')->getCollection();
	    foreach ($collection->getItems() as $data) 
	    {
	    	$data->type_id = Mage::getModel('process/process')->getTypes($data->type_id);
	    	$data->group_id = Mage::getModel('process/process_group')->load($data->group_id)->name;
	    }
	    $this->setCollection($collection);
	    return parent::_prepareCollection();
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

	protected function _prepareColumns()
	{
	    $this->addColumn('process_id', array(
	        'header' => Mage::helper('process')->__('Process Id'),
	        'align' => 'right',
	        'index' => 'process_id',
	    ));

	    $this->addColumn('group_id', array(
	        'header' => Mage::helper('process')->__('Group Name'),
	        'index' => 'group_id',
	    ));

	    $this->addColumn('type_id', array(
				'header' => Mage::helper('process')->__('Type Name'),
				'index' => 'type_id',
		));

	    $this->addColumn('name', array(
	        'header' => Mage::helper('process')->__('Process Name'),
	        'index' => 'name',
	    ));

	    $this->addColumn('per_request_count', array(
	        'header' => Mage::helper('process')->__('Per Request Count'),
	        'index' => 'per_request_count',
	    ));

	    $this->addColumn('request_interval', array(
	        'header' => Mage::helper('process')->__('Request Interval'),
	        'index' => 'request_interval',
	    ));

	    $this->addColumn('request_model', array(
	        'header' => Mage::helper('process')->__('Request Model'),
	        'index' => 'request_model',
	    ));

	    $this->addColumn('file_name', array(
	        'header' => Mage::helper('process')->__('File Name'),
	        'index' => 'file_name',
	    ));

	    $this->addColumn('created_date', array(
	        'header' => Mage::helper('process')->__('Created Date'),
	        'index' => 'created_date',
	    ));

	 //    $this->addColumn('action',
		//     array(
		//         'header'    =>  Mage::helper('process')->__('Action'),
		//         'width'     => '100',
		//         'type'      => 'action',
		//         'getter'    => 'getId',
		//         'actions'   => array(
		//             array(
  //                   'caption'   => Mage::helper('process')->__('Upload'),
  //                   'url'       => array('base'=> '*/adminhtml_processupload/uploadfile'),
  //                   'field'     => 'id'
  //               ),
  //               array(
  //                   'caption'   => Mage::helper('process')->__('Verify'),
  //                   'url'       => array('base'=> '*/adminhtml_processupload/verify'),
  //                   'field'     => 'id'
  //               ),
  //               array(
  //                   'caption'   => Mage::helper('process')->__('Execute'),
  //                   'url'       => array('base'=> '*/adminhtml_processupload/execute'),
  //                   'field'     => 'id'
  //               ),
		//         ),
		//         'filter'    => false,
		//         'sortable'  => false,
		//         'index'     => 'stores',
		//         'is_system' => true,
		// ));

		$this->addColumn('default', array(
            'header'    =>  Mage::helper('process')->__('Download default'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('process')->__('Download'),
                    'url'       => array('base'=> '*/adminhtml_processupload/export'),
                    'field'     => 'id'
                ),
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
    ));
        $this->addColumn('upload', array(
            'header'    =>  Mage::helper('process')->__('Upload'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('process')->__('Upload'),
                    'url'       => array('base'=> '*/adminhtml_processupload/uploadfile'),
                    'field'     => 'id'
                ),
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
    ));

    $this->addColumn('verify', array(
            'header'    =>  Mage::helper('process')->__('Verify'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('process')->__('Verify'),
                    'url'       => array('base'=> '*/adminhtml_processupload/verify'),
                    'field'     => 'id'
                ),

            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
    ));

    $this->addColumn('execution', array(
            'header'    =>  Mage::helper('process')->__('Execute'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('process')->__('Execute'),
                    'url'       => array('base'=> '*/adminhtml_processupload/execute'),
                    'field'     => 'id'
                ),
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
    ));

	    return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
	    return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
	}

}
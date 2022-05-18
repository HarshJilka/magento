<?php 
class Hj_Category_Block_Adminhtml_Category_Index_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _getCategory()
	{
	  $collection = Mage::getModel('category/category')->getCollection();
	  $data_array=array();
	  foreach($collection as $item) {
	    $data_array[]=array('value'=>$item['category_id'],'label'=>$item['name']);
		  if ($item['category_id'] == $this->getRequest()->getParam('id')) {
		  	$this->getRequest()->getParam('id');
		  }
	  }
	  return($data_array);
	}

	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(array(
			'id' => 'edit_form',
			'action' => $this->getUrl('*/*/save',array('id' => $this->getRequest()->getParam('id'))),
			'method' => 'post',
		));
		$this->setForm($form);

		$fieldset = $form->addFieldset('category_form',array('legend' => Mage::helper('category')->__('Category Information')));

		$fieldset->addField('parentid', 'select', array(
	        'name'  => 'selectedParent',
	        'label' => Mage::helper('adminhtml')->__('Parent Id'),
	        'title'     => Mage::helper('adminhtml')->__('Parent Id'),
	        'values'   => $this->selectPaths()
    	));

		$fieldset->addField('name','text',array(
			'label' => Mage::helper('category')->__('Name'),
			'class' => 'required-entry',
			'name' => 'name',
		));	

		$fieldset->addField('status', 'select', array(
                'name'      => 'status',
                'label'     => Mage::helper('adminhtml')->__('Status'),
                'id'        => 'status',
                'title'     => Mage::helper('adminhtml')->__('Status'),
                'class'     => 'input-select',
                'style'        => 'width: 80px',
                'options'    => array('1' => Mage::helper('category')->__('Enable'), '2' => Mage::helper('category')->__('Disable')),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getSalesmanData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSalesmanData());
            Mage::getSingleton('adminhtml/session')->setProData(null);
        } elseif ( Mage::registry('category_data') ) {
            $form->setValues(Mage::registry('category_data')->getData());
        }

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
	}

	public function selectPaths()
    {
        $id = $this->getRequest()->getParam('id');
        $categories = Mage::getModel('category/category')->getCollection()->getItems();
        $finalarray = [];
        $finalarray['root'] = array('value'=>null ,'label'=>'Root Category');
        
        if($id)
        {
            $allPath = Mage::getModel('category/category')->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` WHERE `path` NOT LIKE '%$id%' ORDER BY `path`");
        }
        else
        {
            $allPath = Mage::getModel('category/category')->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` ORDER BY `path`");
        }
        
        foreach ($categories as $category) 
        {
            foreach ($allPath as $data)
            {
                if($category['category_id'] == $data['category_id'])
                {
                    $category_id=$category['category_id'];
                    $path = $category->getPath();
                    $array = array('value'=>$category_id ,'label'=>$path);
                    $finalarray[$category_id]=$array;
                    // echo '<pre>';
                    // print_r($finalarray);
                }
            }  
        }
        return $finalarray;        
    }
}
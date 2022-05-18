<?php 
class Hj_Category_Adminhtml_categoryController extends Mage_Adminhtml_Controller_Action
{
	public function _initAction()
	{
		$this->loadLayout()->_setActiveMenu('category','category');
		return $this;
	}

	public function indexAction()
	{
        // echo "<pre>";
        // $categoryModel = Mage::getModel('category/category');
        // $resource = $categoryModel->getResource();
        /*print_r(get_class_methods($resource));
        print_r($resource);*/

        /*$collection = $categoryModel->getCollection()->getSelect()->where("category_id >? ",10);*//*->orWhere("name = laptop")*/
        /*$select = $categoryModel->getCollection()->getSelect()->where("category_id >? ",10);*//*->orWhere("name = laptop")*/
        // $collection = $categoryModel->getCollection($select)->toArray();
        // print_r($collection);
        // $collection = $categoryModel->getCollection()->addFieldtoSelect('category_id')->addFieldToFilter("category_id",["eq" => 12])->getFirstItem();

        // $data = $categoryModel->getResource()->getReadConnection()->fetchAll($select); 
        // print_r(get_class_methods($collection));
        // echo $collection;
        // print_r($collection);
        // print_r($data);
        // exit();
        
		$this->_initAction();
		$this->getLayout()->getBlock('content')->append(
			$this->getLayout()->createBlock('category/adminhtml_category_index')
		);
		// $this->_addContent($this->getLayout()->createBlock('category/adminhtml_category_index'));
		$this->renderLayout();
	}

	public function editAction()
	{
		$categoryId = $this->getRequest()->getParam('id');
		$categoryModel = Mage::getModel('category/category')->load($categoryId);

		if ($categoryModel->getId() || $categoryId == 0) {
			Mage::register('category_data', $categoryModel);
			$this->loadLayout();
			$this->_setActiveMenu('category/category');
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('category/adminhtml_category_index_edit'));
			// ->_addLeft($this->getLayout()->createBlock('category/adminhtml_category_index_edit_tab'));
			$this->renderLayout();
		}
        else
        {
			$this->_redirect('*/*/');
		}
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function saveAction()
	{
		$categoryModel = Mage::getModel('category/category');
        $request = $this->getRequest();
		$selected_id = $request->getPost('selectedParent');
		$name = $request->getPost('name');
        $id = $request->getParam('id');
        if($request->getPost())
        {
            $postData = $request->getPost();
            unset($postData['selectedParent']);
            $categoryData = $categoryModel->setData($postData);
            if(!empty($id))
            {
                $categoryData->category_id = $id;
                $categoryData->updated_date = date('y-m-d h:m:s');
                if(!$selected_id)
                {
                    $categoryData->parent_id = NULL;
                }
                else
                {
                	$categoryData->parent_id = $selected_id;	
                }
                $result = $categoryModel->save();
                if(!$result)
                {
                	throw new Exception("Sysetm is unable to save your data");   
                }
                $allPath = $categoryModel->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` WHERE `path` LIKE '%$id%' ");
                $updatePath = $categoryModel->getResource()->getReadConnection()->fetchOne("SELECT path FROM `category` WHERE `category_id` = {$result['parent_id']}");
                $updatedPath = $updatePath.'/'.$result['category_id'];
                $parentId = $categoryModel->getResource()->getReadConnection()->fetchOne("SELECT category_id FROM `category` WHERE `category_id` = {$result['parent_id']}");
                foreach ($allPath as $path) 
                {
                	$path['path'] = $updatedPath;
                	$path['parentid'] = $parentId;
                    $savePath = Mage::getModel('category/category');
                    $savePath->setData($path);
                    $result = $savePath->save();
                }
            }
            else
            {
                $categoryData->created_date = date('y-m-d h:m:s');
                if(!$selected_id)
                {
                    $insert = $categoryModel->save();
                    if(!$insert->category_id)
                    {
                        throw new Exception("system is unabel to insert your data");
                    }
                    $category_id = $insert->category_id;
                    $categoryData->unsetData();
                    $categoryData->path = $category_id;
                    $categoryData->category_id = $category_id;
                    $result = $categoryModel->save();
                }
                else
                {
                    $insert = $categoryModel->save();
                    if(!$insert->category_id)
                    {
                        throw new Exception("system is unabel to insert your data");
                    }
                    $new_id = $insert->category_id;
                    $parentPath = $categoryModel->load($selected_id);
                    $categoryData->category_id = $new_id;
                    $categoryData->parentid = $selected_id;
                    $categoryData->name = $name;
                    $categoryData->path = $parentPath->path."/". $new_id;
                    $result = $categoryData->save();
                }
                if(!$result)
                {
                    throw new Exception("Sysetm is unable to save your data");   
                }
            }
        }
 		$this->_redirect('*/*/');
	}

	public function deleteAction()
 	{
 		$categoryModel = Mage::getModel('category/category');
 		$id = (int)$this->getRequest()->getParam('id');
 		$allPath = $categoryModel->getResource()->getReadConnection()->fetchAll("SELECT * FROM `category` WHERE `path` LIKE '%$id%' ");
 		foreach($allPath as $categories)
 		{
 			$delete = $categoryModel->setId($categories['category_id'])->delete();
 		}
 		$this->_redirect('*/*/');
 	}
}
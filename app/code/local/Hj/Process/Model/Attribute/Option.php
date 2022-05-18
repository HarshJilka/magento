<?php
class Hj_Process_Model_Attribute_Option extends Hj_Process_Model_Process_Abstract
{
	protected $optionArray = [];

	protected function _construct()
    {
        $this->_init('eav/attribute_option');
    }

	public function getIdentifier($row)
	{
		return $row['attribute_code'];
	}

	public function prepareRow($row)
	{
		return [
			'attribute_code' => $row['attribute_code'],
			'values' => $this->optionArray[$row['attribute_code']]
		];
	}

	public function validateRow($row)
    {
        $optionValues = [];
        $attribute = Mage::getSingleton('eav/config')
        ->getAttribute(Mage_Catalog_Model_Product::ENTITY, $row['attribute_code']);

        if ($attribute->usesSource()) 
        {
            $options = $attribute->getSource()->getAllOptions(false);
            foreach ($options as $key => $value) 
            {
                array_push($optionValues,$value['label']);
            }
        }
        $optionValuesArray = array_flip($optionValues);

        if(array_key_exists($row['option'] , $optionValuesArray)){
            throw new Exception("option already exists.", 1);       
        }
        $this->prepareOptionArray($row);
        return $row;
    }

	public function prepareOptionArray($row)
	{
		$this->optionArray[$row['attribute_code']] = [];
		$this->optionArray[$row['attribute_code']][$row['option_order']] = $row['option'];
		return $row;
	}

	public function import($entries)
    {
        $installer = new Mage_Eav_Model_Entity_Setup('core_setup');
        foreach ($entries as $key => $row) 
        {
			$row = json_decode($row['data'], true);
			$attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $row['attribute_code']);
			
			$installer->addAttributeOption([
				'attribute_id' => $attribute->getId(),
				'values' => $row['values']
			]); 
           
        }
        return true;
    }
}

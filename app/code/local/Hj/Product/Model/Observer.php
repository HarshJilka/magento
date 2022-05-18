<?php
class Hj_Product_Model_Observer extends Mage_Core_Model_Abstract
{
	public function sendMail(Varien_Event_Observer $observer)
	{

		echo "<pre>";
        echo "Harsh";
        $product = $observer->getEvent()->getProduct();
		print_r($product);
	}

	public function sendMessage(Varien_Event_Observer $observer)
	{
		echo "<pre>";
        echo "Jilka";
        $product = $observer->getEvent()->getProduct();
		print_r($product);
	}
}
<?php
class MD_Productregistration_Block_Customer extends Mage_Core_Block_Template
{
	protected $_customer = false;

	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getCustomer()     
     { 
		if (!$this->_customer) {

			//$banner_id = $this->getData('id');
			$customer_id = $this->getCustomerId();

			//echo $banner_id;

			if ($customer_id) {
				$customer = Mage::getModel('productregistration/customer')->load($customer_id);
				//var_dump($banner);	exit;
				if ($customer->getId()==0) {
					$customer = Mage::getModel('productregistration/customer')->load($customer_id, 'identifier');
				}
				$this->_customer = $customer;
			}
		}
        return $this->_customer;       
    }

	public function isVisible() {
		return $this->getCustomer() && $this->getCustomer()->getStatus();
	}

	public function getInstaller() {
		if ($this->isVisible()) {
			$customer = $this->getCustomer();
	
			$collection = Mage::getModel('productregistration/installer')->getCollection()
				->addFieldToFilter('status', true)
				->addFieldToFilter('installer_id', $customer->getId())
				->setOrder('customer_order','ASC');
			return $collection;
		}
		return false;
	}
	
	public function getProduct() {
		if ($this->isVisible()) {
			$customer = $this->getCustomer();
	
			$collection = Mage::getModel('productregistration/product')->getCollection()
				->addFieldToFilter('status', true)
				->addFieldToFilter('product_id', $customer->getId())
				->setOrder('customer_order','ASC');
			return $collection;
		}
		return false;
	}
	
	public function getBrands() {
        if (is_null($this->_brands)) {
            $this->_brands = Mage::getModel('eav/config')->getAttribute('catalog_product', 'manufacturer')
                ->getSource()->getAllOptions(false);
        }

        return $this->_brands;
    }
}
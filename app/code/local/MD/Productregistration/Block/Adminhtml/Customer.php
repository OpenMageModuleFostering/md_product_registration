<?php
class MD_Productregistration_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_customer';
    $this->_blockGroup = 'productregistration';
    $this->_headerText = Mage::helper('productregistration')->__('Product Registration');
    parent::__construct();
	$this->_removeButton('add');
  }
}

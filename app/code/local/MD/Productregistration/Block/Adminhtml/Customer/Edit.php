<?php

class MD_Productregistration_Block_Adminhtml_Customer_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'productregistration';
        $this->_controller = 'adminhtml_customer';
		// $this->_removeButton('save');
        $this->_updateButton('delete', 'label', Mage::helper('productregistration')->__('Delete Customer Information'));
		
    }
    public function getHeaderText()
    {
        if( Mage::registry('productregistration_data') && Mage::registry('productregistration_data')->getId() ) {
            return Mage::helper('productregistration')->__("Product Registration # '%s'", $this->htmlEscape(Mage::registry('productregistration_data')->getInvoice()));
        } else {
            return Mage::helper('productregistration')->__('Product Registration #');
        }
    }	
}
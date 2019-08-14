<?php

class MD_Productregistration_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('productregistration_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('productregistration')->__('Product Registration'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('productregistration')->__('Product Registration Information'),
          'title'     => Mage::helper('productregistration')->__('Product Registration Information'),
          'content'   => $this->getLayout()->createBlock('productregistration/adminhtml_customer_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
<?php

class MD_Productregistration_Model_Mysql4_Installer_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productregistration/installer');
    }
}
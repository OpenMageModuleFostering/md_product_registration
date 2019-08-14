<?php

class MD_Productregistration_Model_Status extends Varien_Object
{
    const STATUS_PENDDING	= 1;
    const STATUS_APPROVE	= 2;
    const STATUS_REJECT		= 3;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_PENDDING    => Mage::helper('productregistration')->__('Pendding'),
            self::STATUS_APPROVE    => Mage::helper('productregistration')->__('Approve'),
            self::STATUS_REJECT	   => Mage::helper('productregistration')->__('Reject')
        );
    }
}
<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('md_customer')};
CREATE TABLE {$this->getTable('md_customer')} (
  `customer_id` int(11) unsigned NOT NULL auto_increment,
  `invoice` varchar(255) NOT NULL default '',
  `namecus` varchar(255) NOT NULL default '',
  `emailcus` varchar(255) NOT NULL default '',
  `datecus` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  `status` int(11) NOT NULL default '1',
  `comment` varchar(500) NOT NULL default '',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('md_installer')};
CREATE TABLE {$this->getTable('md_installer')} (
  `installer_id` int(11) unsigned NOT NULL auto_increment,
  `customer_id` int(11) unsigned NOT NULL,
  `nameins` varchar(255) NOT NULL default '',
  `addressins` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `state` varchar(255) NOT NULL default '',
  `zip` varchar(255) NOT NULL default '',
  `emailadd` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `recommend` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`installer_id`),
  CONSTRAINT `FK_MD_INSTALLER` FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('md_customer')}` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- DROP TABLE IF EXISTS {$this->getTable('md_product')};
CREATE TABLE {$this->getTable('md_product')} (
  `product_id` int(11) unsigned NOT NULL auto_increment,
  `customer_id` int(11) unsigned NOT NULL,
  `eqipment1` varchar(255) NOT NULL default '',
  `eqipment2` varchar(255) NOT NULL default '',
  `eqipment3` varchar(255) NOT NULL default '',
  `modelnumber1` varchar(255) NOT NULL default '',
  `modelnumber2` varchar(255) NOT NULL default '',
  `modelnumber3` varchar(255) NOT NULL default '',
  `serial1` varchar(255) NOT NULL default '',
  `serial2` varchar(255) NOT NULL default '',
  `serial3` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`product_id`),
  CONSTRAINT `FK_MD_PRODUCT` FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('md_customer')}` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 

?>
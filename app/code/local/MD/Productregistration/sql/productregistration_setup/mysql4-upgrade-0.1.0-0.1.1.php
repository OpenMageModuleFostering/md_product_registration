<?php

$installer = $this;

$installer->startSetup();

$installer->run("
	alter table md_customer add store_id varchar(255) NOT NULL default '1';
");

$installer->endSetup(); 

?>
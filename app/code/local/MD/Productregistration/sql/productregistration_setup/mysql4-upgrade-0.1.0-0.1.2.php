<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('md_customer')};
DROP TABLE IF EXISTS {$this->getTable('md_installer')};
DROP TABLE IF EXISTS {$this->getTable('md_product')};

    ");

$installer->endSetup(); 

?>
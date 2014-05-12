<?php

$installer = $this;
$installer->startSetup();
$table = $installer->run("
DROP TABLE IF EXISTS {$this->getTable('devils_details_entity')};
CREATE TABLE {$this->getTable('devils_details_entity')} (
  `entity_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL default '',
  `image` VARCHAR(255) NOT NULL,
  `active` tinyint(1) NOT NULL default 1,
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();

$eavInstaller = Mage::getModel('eav/entity_setup','default_setup');
$eavInstaller->startSetup();
$eavInstaller->removeAttribute('catalog_product','devils_details');
$eavInstaller->addAttribute('catalog_product','devils_details', array(
    'type' => 'text',
    'backend' => 'devils_details/catalog_product_attribute_backend_details',
    'frontend' => 'devils_details/catalog_product_attribute_frontend_details',
    'source' => 'devils_details/catalog_product_attribute_source_details',
    'label' => 'Details',
    'input' => 'multiselect',
    'class' => '',
    'user_defined' => false,
    'default' => '',
    'unique' => false,
    'visible_on_front' => true
));
$eavInstaller->endSetup();
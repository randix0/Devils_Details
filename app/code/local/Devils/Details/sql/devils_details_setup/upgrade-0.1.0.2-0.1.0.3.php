<?php

$installer = Mage::getModel('eav/entity_setup','default_setup');
$installer->startSetup();

$table = $installer->run("
ALTER TABLE  {$this->getTable('devils_details_entity')} ADD  `image` VARCHAR( 255 ) NOT NULL AFTER  `description` ;");

$installer->endSetup();
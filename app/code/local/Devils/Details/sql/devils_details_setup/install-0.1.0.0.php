<?php

$installer = $this;
$installer->startSetup();

$table = $installer->run("
DROP TABLE IF EXISTS {$this->getTable('devils_details_entity')};
CREATE TABLE {$this->getTable('devils_details_entity')} (
  `entity_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL default '',
  `active` tinyint(1) NOT NULL default 1,
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
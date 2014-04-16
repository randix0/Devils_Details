<?php

$installer = Mage::getModel('eav/entity_setup','default_setup');
$installer->startSetup();

$installer->removeAttribute('catalog_product','devils_details');

$installer->addAttribute('catalog_product','devils_details', array(
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

$installer->endSetup();
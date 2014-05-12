<?php

class Devils_Details_Model_Resource_Details extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct() {
        $this->_init('devils_details/details_source', 'entity_id');
    }
}
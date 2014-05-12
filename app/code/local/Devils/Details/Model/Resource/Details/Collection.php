<?php

class Devils_Details_Model_Resource_Details_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct() {
        $this->_init('devils_details/details');
    }
}
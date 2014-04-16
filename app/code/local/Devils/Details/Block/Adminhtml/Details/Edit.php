<?php

class Devils_Details_Block_Adminhtml_Details_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
    protected function _construct() {
        parent::_construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'devils_details';
        $this->_controller = 'adminhtml_details';
    }
}
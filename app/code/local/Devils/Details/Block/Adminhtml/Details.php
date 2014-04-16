<?php

class Devils_Details_Block_Adminhtml_Details extends Mage_Adminhtml_Block_Widget_Grid_Container {
    protected function _construct() {
        $this->_blockGroup = 'devils_details';
        $this->_controller = 'adminhtml_details';
        $this->_headerText = $this->__('List');
        $this->_addButtonLabel = $this->__('Add Detail');
        parent::_construct();
    }
}
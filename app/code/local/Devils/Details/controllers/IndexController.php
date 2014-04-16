<?php

class Devils_Details_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
        //echo 'DEVils';

        $collection = Mage::getResourceModel('devils_details/details_collection');

        $options = array();

        foreach($collection->getItems() as $detail) {
            $options[] = array('label' => $detail->getName(), 'value' => $detail->getId());
        }

        var_dump(Mage::getBaseDir('media') . DS . 'details');
    }
}
<?php

class Devils_Details_IndexController extends Mage_Core_Controller_Front_Action
{
    protected function _initDetail()
    {
        $detailId = (int) $this->getRequest()->getParam('id', false);
        if (!$detailId) {
            return false;
        }

        $detail = Mage::getModel('devils_details/details')
            ->load($detailId);
        return $detail;
    }

    public function indexAction() {
        $collection = Mage::getResourceModel('devils_details/details_collection');

        $options = array();

        foreach($collection->getItems() as $detail) {
            $options[] = array('label' => $detail->getName(), 'value' => $detail->getId());
        }

        var_dump(Mage::getBaseDir('media') . DS . 'details');
    }

    public function viewAction()
    {
        if ($detail = $this->_initDetail()) {
            echo $detail->getName();
        } elseif (!$this->getResponse()->isRedirect()) {
            $this->_forward('noRoute');
        }
    }
}
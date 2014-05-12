<?php

class Devils_Details_IndexController extends Mage_Core_Controller_Front_Action
{
    protected function _initDetail()
    {
        $detailId = (int) $this->getRequest()->getParam('id', false);
        if (!$detailId) {
            return false;
        }
        $detail = Mage::helper('devils_details')->initDetail($detailId);
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

        } elseif (!$this->getResponse()->isRedirect()) {
            $this->_forward('noRoute');
        }

        //$this->loadLayout();
        $update = $this->getLayout()->getUpdate();
        $update->addHandle('default');
        $this->addActionLayoutHandles();
        $update->addHandle('devils_details_view');
        $this->loadLayoutUpdates();
        $this->generateLayoutXml();
        $this->generateLayoutBlocks();
        $this->_isLayoutLoaded = true;

        //print_r($this->getLayout()->getUpdate()->getHandles());

        $this->renderLayout();
    }
}
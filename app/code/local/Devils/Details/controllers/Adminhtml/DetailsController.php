<?php

class Devils_Details_Adminhtml_DetailsController extends Mage_Adminhtml_Controller_Action {
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('devils/devils_details');
    }

    public function indexAction() {
        $this->_redirect('*/*/list');
    }

    public function listAction() {
        $this->loadLayout();
        $this->_setActiveMenu('devils/devils_details');
        $this->renderLayout();
    }

    public function gridAction() {
        $this->loadLayout(false);
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_initDetail('id');

        if (!$model->getId() && $id) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('devils_details')->__('This distributor no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New Detail'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        $this->loadLayout();
        $this->_setActiveMenu('devils/devils_details');
        $breadcrumbMessage = $id ? Mage::helper('devils_details')->__('Edit Detail')
            : Mage::helper('devils_details')->__('New Detail');
        $this->_addBreadcrumb($breadcrumbMessage, $breadcrumbMessage)
            ->renderLayout();
    }

    protected function _initDetail($idFieldName = 'entity_id')
    {
        $this->_title($this->__('Catalog'))->_title($this->__('Details'));

        $id = (int)$this->getRequest()->getParam($idFieldName);
        $model = Mage::getModel('devils_details/details');
        if ($id) {
            $model->load($id);
        }
        if (!Mage::registry('current_detail')) {
            Mage::register('current_detail', $model);
        }
        return $model;
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $detail = $this->_initDetail();

            $result = null;
            $isUploaded = true;
            try {
                /** @var $uploader Mage_Core_Model_File_Uploader */
                $uploader = Mage::getModel('core/file_uploader', 'image');
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setAllowCreateFolders(true);
                $uploader->setFilesDispersion(false);
            } catch (Exception $e) {
                $isUploaded = false;
            }

            $deleteImage = false;
            if (isset($data['image']['delete'])) {
                $deleteImage = true;
            }
            unset($data['image']);

            $detail->addData($data);

            if ($deleteImage) {
                $detail->setImage('');
            }

            if ($isUploaded) {
                $result = $uploader->save(Mage::getBaseDir('media') . DS . 'details' . DS);
                $detail->setImage(Mage::getBaseUrl('media') . 'details' . DS . $result['name']);
            }

            $detail->save();

            if ($this->getRequest()->getParam('back')) {
                $params = array('id' => $detail->getId());
                $this->_redirect('*/*/edit', $params);
            } else {
                $this->_redirect('*/*/list');
            }
        }
        $this->_redirect('*/*/');
    }
}
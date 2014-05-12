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

            try {
                $detail->save();
                $detailId = $detail->getId();
            } catch (Exception $e) {
                return $this->_redirect('*/*/');
            }

            if ($isUploaded) {
                $result = $uploader->save(Mage::getBaseDir('media') . DS . 'devils' . DS . 'devils_details' . DS . 'details' . DS . $detailId . DS);
                $detail->setImage($result['name']);
                $detail->save();
            }

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('devils_colors')->__('%s was successfully saved', $detail->getName()));

            if ($this->getRequest()->getParam('back')) {
                $params = array('id' => $detail->getId());
                $this->_redirect('*/*/edit', $params);
            } else {
                $this->_redirect('*/*/list');
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if($this->getRequest()->getParam('id') > 0)
        {
            try
            {
                $id = $this->getRequest()->getParam('id');
                $color = Mage::getModel('devils_details/details');
                $color->setId($id)->delete();

                $colorPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'devils' . DS . 'devils_details' . DS . 'details' . DS . $id;
                $cachePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'devils' . DS . 'devils_details' . DS . 'cache' . DS . $id;
                $this->_clearDir($colorPath);
                $this->_clearDir($cachePath);

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Detail was successfully deleted'));
                $this->_redirect('*/*/');
            }catch(Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    protected function _clearDir($dir)
    {
        if(file_exists($dir)){
            $glob = glob($dir . '/*');
            if($glob){
                foreach($glob as $file){
                    if(is_dir($file)){
                        $this->_clearDir($file);
                    }else{
                        unlink($file);
                    }
                }
                rmdir($dir);
            }
        }
    }
}
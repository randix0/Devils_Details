<?php

class Devils_Details_Block_Adminhtml_Details_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {
    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save',
                    $this->getRequest()->getParam('id')),
            'method' => 'post',
            'enctype'=> 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset('general_form', array(
            'legend' => $this->__('General Setup')
        ));

        $fieldset->addField('name', 'text', array(
            'label' => $this->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name'
        ));

        $fieldset->addField('image', 'image', array(
                'label' => $this->__('Image'),
                'scope' => 'store',
                'name'  => 'image'
            )
        );

        $fieldset->addField('description', 'text', array(
            'label' => $this->__('Description'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'description'
        ));

        $fieldset->addField('active', 'select', array(
            'label' => $this->__('Active'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'active',
            'options' => array(
                0 => $this->__('No'),
                1 => $this->__('Yes')
            )
        ));

        $detail = Mage::registry('current_detail');

        if ($detail->getId()) {
            $form->addField('entity_id', 'hidden', array(
                'name' => 'entity_id',
            ));
            $form->setValues($detail->getData());
        }

        $form->setUseContainer(true);
        $form->addValues($this->_getFormData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    protected function _getFormData() {
        $data = Mage::getSingleton('adminhtml/session')->getFormData();
    }
}
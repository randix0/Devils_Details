<?php

class Devils_Details_Model_Catalog_Product_Attribute_Backend_Details
    extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    public function beforeSave($object) {
        $attributeCode = $this->getAttribute()->getName();
        if ($attributeCode == 'devils_details') {
            $data = $object->getData($attributeCode);
            if (!is_array($data)) {
                $data = array();
            }
            $object->setData($attributeCode, join(',', $data));
        }
        if (is_null($object->getData($attributeCode))) {
            $object->setData($attributeCode, false);
        }
        return $this;
    }

    public function afterLoad($object) {
        $attributeCode = $this->getAttribute()->getName();
        if ($attributeCode == 'devils_details') {
            $data = $object->getData($attributeCode);
            if ($data) {
                $object->setData($attributeCode, explode(',', $data));
            }
        }
        return $this;
    }
}
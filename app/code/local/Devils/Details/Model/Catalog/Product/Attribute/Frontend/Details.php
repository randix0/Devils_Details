<?php
class Devils_Details_Model_Catalog_Product_Attribute_Frontend_Details
    extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
    public function getDetails(Varien_Object $object)
    {
        $optionIds = $object->getData($this->getAttribute()->getAttributeCode());
        $source = $this->getAttribute()->getSource();
        if ($source) {
            return $source->getOptionData($optionIds);
        }
        return false;
    }
}
<?php
class Devils_Details_Block_Details extends Mage_Catalog_Block_Product_View_Attributes
{
    public function getDetails()
    {
        $data = array();
        $_attribute = false;
        $product = $this->getProduct();
        $attributes = $product->getAttributes();

        foreach ($attributes as $attribute) {
            if ($attribute->getAttributeCode() == 'devils_details') {
                $_attribute = $attribute;
                break;
            }
        }

        if (!$_attribute || empty($_attribute)) {
            return false;
        }

        $data = $_attribute->getFrontend()->getDetails($product);
        return $data;
    }

    public function getDetail()
    {

    }
}
<?php

class Devils_Details_Helper_Data extends Mage_Core_Helper_Abstract {
    public function getSwatchImage($id, $file)
    {
        $display = Mage::getStoreConfig('devils_details/general/display');
        $path = '/media/devils/devils_details/details/%s/%s';
        if((int)$display === 0){
            return $this->_getResizedImage($file, $id, 120, 120);
        }
        return sprintf($path, $id, $file);
    }

    protected function _getResizedImage($filename, $dir, $width, $height = null)
    {
        $imagePath = Mage::getBaseDir('media') . DS . 'devils' . DS . 'devils_details' . DS . 'details' . DS . $dir . DS . $filename;
        $imageResized = Mage::getBaseDir('media') . DS . 'devils' . DS . 'devils_details' . DS . 'cache' . DS . $dir . DS . $width . '_' . (string)$height . '_' . $filename;
        if(!file_exists($imageResized) && file_exists($imagePath) || file_exists($imagePath) && filemtime($imagePath) > filemtime($imageResized)){
            $imageObj = new Varien_Image($imagePath);
            $imageObj->constrainOnly(true);
            $imageObj->keepAspectRatio(false);
            $imageObj->keepFrame(false);
            $imageObj->quality(100);
            $imageObj->resize($width, $height);
            $imageObj->save($imageResized);
        }

        $imageCacheUrl = '/media/devils/devils_details/cache/' . $dir . '/' . $width . '_' . (string)$height . '_' . $filename;

        if(file_exists($imageResized)){
            return $imageCacheUrl;
        }
        return '';
    }
}
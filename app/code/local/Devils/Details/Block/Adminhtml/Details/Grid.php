<?php

class Devils_Details_Block_Adminhtml_Details_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function _construct() {
        parent::_construct();
        $this->setId('devils_details_grid');
        $this->setDefaultSort('id');
        //$this->setUseAjax(true);
    }

    protected function _prepareColumns() {
        $this->addColumn('id', array(
            'header' => $this->__('ID'),
            'sortable' => true,
            'width' => '60px',
            'index' => 'entity_id'
        ));

        $this->addColumn('name', array(
            'header' => $this->__('Name'),
            'type'   => 'text',
            'index'  => 'name',
            'escape' => true
        ));
        $this->addColumn('description', array(
            'header' => $this->__('Description'),
            'type'   => 'text',
            'index'  => 'name',
            'escape' => true
        ));
        $this->addColumn('active', array(
            'header'    => $this->__('Active'),
            'align'     => 'center',
            'width'     => 1,
            'index'     => 'active',
            'type'      => 'options',
            'options'   => array(
                0 => $this->__('No'),
                1 => $this->__('Yes')
            ),
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('devils_details/details_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
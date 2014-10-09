<?php

class Elgentos_Customdiscount_Block_Adminhtml_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('customdiscount_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customdiscount/discounts')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $fields = array(
            'ID'=>'id',
            'Email'=>'email',
            'Product SKU'=>'sku',
            'Custom price' => 'custom_price',
            'Unique link' => 'discountUrl',
            'Times used' => 'used',
        );

        foreach($fields as $field=>$index) {
            $options = array(
                'header'    => Mage::helper('customdiscount')->__($field),
                'index'     => $index,
            );
            if($index=='sku') {
                $options['renderer'] = 'Elgentos_Customdiscount_Block_Adminhtml_Renderers_Sku';
            } elseif($index=='email') {
                $options['renderer'] = 'Elgentos_Customdiscount_Block_Adminhtml_Renderers_Customer';
            } elseif($index=='discountUrl') {
                $options['renderer'] = 'Elgentos_Customdiscount_Block_Adminhtml_Renderers_DiscountUrl';
            }
            
            $this->addColumn($field, $options);
        }

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/adminhtml_index/form', array('id' => $row->getId()));
    }
}
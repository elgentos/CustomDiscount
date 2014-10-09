<?php

class Elgentos_Customdiscount_Block_Adminhtml_Index extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    //protected $_addButtonLabel = 'Add New Example';

    public function __construct()
    {
        parent::__construct();
        $this->removeButton('add');
        $this->_controller = 'adminhtml_index';
        $this->_blockGroup = 'customdiscount';
        $this->_headerText = Mage::helper('customdiscount')->__('Discounts');

        $this->_addButton('add', array(
            'label' => 'Voeg offerte korting toe',
            'onclick' => 'setLocation(\''.$this->getUrl('*/*/form').'\')'
        ));
    }

    protected function _prepareLayout()
    {
        $this->setChild('grid',
            $this->getLayout()->createBlock( $this->_blockGroup.'/' . $this->_controller . '_grid',$this->_controller . '.grid')->setSaveParametersInSession(true)
        );
        return parent::_prepareLayout();
    }
}
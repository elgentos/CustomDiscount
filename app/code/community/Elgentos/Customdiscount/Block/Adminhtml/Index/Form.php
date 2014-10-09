<?php

class Elgentos_Customdiscount_Block_Adminhtml_Index_Form extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _prepareLayout()
    {
        if ($this->_blockGroup && $this->_controller && $this->_mode) {
            $this->setChild('form', $this->getLayout()->createBlock($this->_blockGroup . '/' . $this->_controller . '_' . $this->_mode . '_form'));
        }
        return parent::_prepareLayout();
    }

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'customdiscount';
        $this->_controller = 'adminhtml_index';
        $this->_mode = 'form';

        $this->_updateButton('save', 'label', Mage::helper('customdiscount')->__('Submit'));

    }

    public function getHeaderText()
    {
        return Mage::helper('customdiscount')->__('New discount');
    }

}
<?php
class Elgentos_Customdiscount_Block_Adminhtml_Renderers_Customer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $value =  $row->getData('email');
        $customer = Mage::getModel('customer/customer')->loadByEmail($value);
        if($customer->getId()) {
            return '<a href="'.Mage::getUrl('adminhtml/customer/edit/',array('id'=>$customer->getId())).'">'.$customer->getFirstname().' '.$customer->getLastname().'</a>';
        } else {
            return $value.' ('.Mage::helper('customdiscount')->__('new customer').')';
        }
    }

}
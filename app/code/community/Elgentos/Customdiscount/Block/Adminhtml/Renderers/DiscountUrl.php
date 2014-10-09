<?php
class Elgentos_Customdiscount_Block_Adminhtml_Renderers_DiscountUrl extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $value =  $row->getData();
        unset($value['id']);
        unset($value['hash']);
        unset($value['used']);
        $hash = sha1(implode($value));
        return '<a href="javascript:alert(\''.Mage::helper('customdiscount')->getDiscountUrl($hash).'\')">Link</a>';
    }

}
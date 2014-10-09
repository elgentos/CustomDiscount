<?php
class Elgentos_Customdiscount_Block_Adminhtml_Renderers_Sku extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $value =  $row->getData('sku');
        $product = Mage::getModel('catalog/product')->loadByAttribute('sku',$value);
        if($product) {
            return '<a href="' . $product->getProductUrl() . '">'.$product->getName().'</a>';
        } else {
            return 'Product not found';
        }
    }

}

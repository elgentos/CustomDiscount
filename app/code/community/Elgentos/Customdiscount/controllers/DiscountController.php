<?php
class Elgentos_Customdiscount_DiscountController extends Mage_Core_Controller_Front_Action {
    
    public function indexAction() {
        $useLimit = Mage::getStoreConfig('customdiscount/general/uselimit');
        if(empty($useLimit) || !$useLimit) $useLimit = 1;
        $hash = $this->getRequest()->getParam('hash');
        $discount = Mage::getModel('customdiscount/discounts')->loadByHash($hash);
        if($discount!==false) {
            $discountData = $discount->getData();
            unset($discountData['hash']);
            unset($discountData['id']);
            $used = $discountData['used'];
            unset($discountData['used']);
            $checkHash = sha1(implode($discountData)); 
            
            if($checkHash==$hash) {
                if($used>=$useLimit) {
                    Mage::getSingleton('core/session')->addError(Mage::helper('customdiscount')->__('This offer has already been used, sorry.'));
                    $this->_redirect('/');
                } else {
                    $cart = Mage::getSingleton('checkout/cart');
                    $product = Mage::getModel('catalog/product')->setStoreId(Mage::app()->getStore()->getId())->loadByAttribute('sku',$discountData['sku']);
                    if($product) {
                        try {
                            $product = Mage::getModel('catalog/product')->setStoreId(Mage::app()->getStore()->getId())->load($product->getId());
                            $cart->addProduct($product, array('product'=>$product->getId(),'qty' => 1));
                            foreach ($cart->getQuote()->getAllVisibleItems() as $item) {
                                 if ($item->getParentItem()) {
                                     $item = $item->getParentItem();
                                 }
    
                                 // Make sure we don't have a negative
                                 if ($discountData['custom_price'] > 0) {
                                     $item->setCustomPrice($discountData['custom_price']);
                                     $item->setOriginalCustomPrice($discountData['custom_price']);
                                     $item->getProduct()->setIsSuperMode(true);
                                 }
                            }
                            $cart->save();
                            $used = ($used*1)+1;
                            $discount->setData('used',$used)->save();
                            Mage::getSingleton('core/session')->addSuccess(Mage::helper('customdiscount')->__('The offer is added to your cart.'));
                            $this->_redirect('checkout/cart');
                        } catch(Exception $e) {
                            Mage::getSingleton('core/session')->addError(Mage::helper('customdiscount')->__('Offer could not be added to your cart; '.$e->getMessage()));
                            $this->_redirect('/');
                        }
                    } else {
                        Mage::getSingleton('core/session')->addError(Mage::helper('customdiscount')->__('Product could not be found.'));
                        $this->_redirect('/');
                    }
                }
            } else {
                Mage::getSingleton('core/session')->addError(Mage::helper('customdiscount')->__('Sorry, the offer is not valid anymore.'));
                $this->_redirect('/');
            }
        } else {
            Mage::getSingleton('core/session')->addError(Mage::helper('customdiscount')->__('The offer could not be found.'));
            $this->_redirect('/');
        }
    }
    
    public function requestAction() {
        $params = $this->getRequest()->getParams();
        $data = array(
            'sku' => $params['sku'],
            'customer' => $params['email'],
            'offerUrl' => Mage::getUrl('customdiscount/adminhtml_index/form',array('email'=>$params['email'],'sku'=>$params['sku']))
        );
        Mage::helper('customdiscount')->sendRequestMail($data);
        Mage::getSingleton('core/session')->addSuccess(Mage::helper('customdiscount')->__('Your request for an offer has been sent. Thank you for your interest!'));
        $this->_redirectReferer();
    }
    
}
    
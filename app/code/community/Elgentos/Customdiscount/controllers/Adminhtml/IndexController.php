<?php

class Elgentos_Customdiscount_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction($title=null) {
        $this->loadLayout();
        if($title!=null) {
            $this->getLayout()->getBlock('head')->setTitle($title.' / Magento Admin');
        }
        $this->_setActiveMenu('customdiscount/index');
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction('Custom discount')->renderLayout();
    }
    
    public function deleteAction() {
        try {
            Mage::getModel('adminhtml/session')->addSuccess(__('Discount has been succesfully deleted.'));
            Mage::getModel('customdiscount/discounts')->load($this->getRequest()->getParam('id'))->delete();
        } catch(Exception $e) {
            Mage::getModel('adminhtml/session')->addError(__('Discount could not be deleted; ').$e->getMessage());
        }
        $this->_redirect('customdiscount/adminhtml_index');
    }
    
    public function formAction() {
        $this->_initAction('Custom discount')->renderLayout();
    }
    
    public function process_discountAction() {
        $id = $this->getRequest()->getParam('id');
        $discount = $this->getRequest()->getParam('discount');
        unset($discount['used']);
        
        $discountModel = Mage::getModel('customdiscount/discounts');
        $discountEntity = $discountModel->load($id);
        if($discountEntity) {
            $discountEntity->setData('id',$id);
        } else {
            $discountEntity = $discountModel;
        }
        foreach($discount as $key=>$value) {
            $discountEntity->setData($key,$value);
        }
        try {
            $hash = sha1(implode($discount));
            $discountEntity->setData('hash',$hash);
            $discountEntity->save();
            if($this->getRequest()->getParam('send_email')) {
                $data = array(
                    'sku' => $discount['sku'],
                    'to' => $discount['email'],
                    'newPrice' => Mage::helper('core')->currency($discount['custom_price'],true,false),
                    'discountUrl' => Mage::helper('customdiscount')->getDiscountUrl($hash) 
                );
                Mage::helper('customdiscount')->sendOfferMail($data);
                Mage::getModel('adminhtml/session')->addSuccess(__('Discount has been saved succesfully and mail has been sent to the customer.'));
            } else {
                Mage::getModel('adminhtml/session')->addSuccess(__('Discount has been saved succesfully.'));
            }
        } catch(Exception $e) {
            Mage::getModel('adminhtml/session')->addError(__('Could not save discount; ') . $e->getMessage());
        }
        $this->_redirect('customdiscount/adminhtml_index');
    }

}
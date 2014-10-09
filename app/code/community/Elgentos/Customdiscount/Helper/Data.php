<?php

class Elgentos_Customdiscount_Helper_Data extends Mage_Core_Helper_Abstract {
    
    public function sendOfferMail($emailTemplateVariables) {
        $generalContact = Mage::getStoreConfig('trans_email/ident_general/email');
        $storeName = Mage::getStoreConfig('general/store_information/name');
        $product = Mage::getModel('catalog/product')->loadByAttribute('sku',$emailTemplateVariables['sku']);
        $emailTemplateVariables['product'] = $product;
        $emailTemplate  = Mage::getModel('core/email_template')->loadDefault('offermail');
        $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
        $emailTemplate->setSenderName($storeName);
        $emailTemplate->setSenderEmail($generalContact);
        $emailTemplate->setTemplateSubject($this->__('One-time unique offer for ').$product->getName());
        $emailTemplate->send($emailTemplateVariables['to'],$this->__('Customer'), $emailTemplateVariables); 
    }
    
    public function sendRequestMail($emailTemplateVariables) {
        $generalContact = Mage::getStoreConfig('trans_email/ident_general/email');
        $storeName = Mage::getStoreConfig('general/store_information/name');
        $product = Mage::getModel('catalog/product')->loadByAttribute('sku',$emailTemplateVariables['sku']);
        $emailTemplateVariables['product'] = $product;
        $emailTemplate  = Mage::getModel('core/email_template')->loadDefault('requestmail');
        $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
        $emailTemplate->setSenderName($storeName);
        $emailTemplate->setSenderEmail($generalContact);
        $emailTemplate->setTemplateSubject($this->__('Discount request for ').$product->getName());
        $emailTemplate->send($generalContact, $storeName, $emailTemplateVariables);
    }
    
    public function getDiscountUrl($hash) {
        return Mage::getUrl('discount/discount',array('hash'=>$hash));
    }
    
}

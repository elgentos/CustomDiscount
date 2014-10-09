<?php

class Elgentos_Customdiscount_Block_Adminhtml_Index_Form_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $_discount = Mage::getModel('customdiscount/discounts')->load($this->getRequest()->getParam('id'));
        $edit = true;

        $dataForm = array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/process_discount', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
        );
        if($edit) {
            $dataForm['action'] = $this->getUrl('*/*/process_discount', array('id' => $this->getRequest()->getParam('id')));
        }
        $form = new Varien_Data_Form($dataForm);

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('Custom discount', array(
             'legend' =>Mage::helper('customdiscount')->__('Custom discount')
        ));

        $email = $this->getRequest()->getParam('email');

        $fieldset->addField('email', 'text', array(
            'name'      => 'discount[email]',
            'label'     => Mage::helper('customdiscount')->__('E-mail'),
            'class'     => 'required-entry',
            'required'  => true,
            'value' => (!empty($email) ? $email : $_discount->getEmail())
        ));

        $sku = $this->getRequest()->getParam('sku');
        $fieldset->addField('sku', 'text', array(
            'name'      => 'discount[sku]',
            'label'     => Mage::helper('customdiscount')->__('Sku'),
            'class'     => 'required-entry',
            'required'  => true,
            'value' => (!empty($sku) ? $sku : $_discount->getSku())
        ));

        if(!empty($sku)) {
            $price = Mage::getModel('catalog/product')->loadByAttribute('sku',$sku)->getFinalPrice();
        }
        $fieldset->addField('custom_price', 'text', array(
            'name'      => 'discount[custom_price]',
            'label'     => Mage::helper('customdiscount')->__('Custom price'),
            'class'     => 'required-entry',
            'required'  => true,
            'value' => (isset($price) ? $price : $_discount->getCustomPrice())
        ));
        
        if(!empty($sku) || ($_discount->getUsed()*1)>0) {
            $fieldset->addField('used', 'text', array(
                'name'      => 'discount[used]',
                'label'     => Mage::helper('customdiscount')->__('Times used'),
                'class'     => 'required-entry',
                'required'  => true,
                'value' => $_discount->getUsed()
            ));
        }

        $fieldset->addField('send_email', 'checkbox', array(
            'name'      => 'send_email',
            'label'     => Mage::helper('customdiscount')->__('Send discount link to customer'),
            'value' => '1',
            'checked' => 'checked'
        ));

        return parent::_prepareForm();
    }
}
<?php

class FireGento_GermanSetup_Adminhtml_Checkout_Agreement_Edit_Form
extends Mage_Adminhtml_Block_Checkout_Agreement_Edit_Form {
    protected function _prepareForm()
    {
        parent::_prepareForm();
        $form = $this->getForm();        
        
        $fieldset = $form->getElement('base_fieldset');
        $fieldset->addField('is_required', 'select', array(
            'label'     => Mage::helper('germansetup')->__('Required'),
            'title'     => Mage::helper('germansetup')->__('Required'),
            'note'      => Mage::helper('germansetup')->__('Display Checkbox on Frontend'),
            'name'      => 'is_required',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('germansetup')->__('Yes'),
                '0' => Mage::helper('germansetup')->__('No'),
            ),
        ));
        
        $model  = Mage::registry('checkout_agreement');
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
        
        return $this;
    }
}
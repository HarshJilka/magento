<?php
class Hj_Salesman_Block_Adminhtml_Salesman_Index_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
        ));
        $this->setForm($form);
        $fieldset = $form->addFieldset('salesman_form', array('legend'=>Mage::helper('salesman')->__('Salesman information')));

        $fieldset->addField('first_name', 'text', array(
            'label' => Mage::helper('salesman')->__('First Name'),
            'class' => 'required-entry',
            'name' => 'first_name',
        ));

        $fieldset->addField('last_name', 'text', array(
            'label' => Mage::helper('salesman')->__('Last Name'),
            'name' => 'last_name',
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('salesman')->__('Email'),
            'class' => 'required-entry',
            'name' => 'email',
        ));

        $fieldset->addField('mobile', 'text', array(
            'label' => Mage::helper('salesman')->__('Mobile Number'),
            'class' => 'required-entry',
            'name' => 'mobile',
        ));

        $fieldset->addField('percentage', 'text', array(
            'label' => Mage::helper('salesman')->__('Discount'),
            'class' => 'required-entry',
            'name' => 'percentage',
        ));

        $fieldset->addField('status', 'select', array(
                'name'      => 'status',
                'label'     => Mage::helper('adminhtml')->__('Status'),
                'id'        => 'status',
                'title'     => Mage::helper('adminhtml')->__('Status'),
                'class'     => 'input-select',
                'style'        => 'width: 80px',
                'options'    => array('1' => Mage::helper('salesman')->__('Active'), '2' => Mage::helper('salesman')->__('Inactive')),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getSalesmanData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSalesmanData());
            Mage::getSingleton('adminhtml/session')->setProData(null);
        } elseif ( Mage::registry('salesman_data') ) {
            $form->setValues(Mage::registry('salesman_data')->getData());
        }

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}

<?php

class Bizrate_Buyerssurvey_Model_System_Config_Source_Bizratemedal extends Mage_Core_Block_Template
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => '0', 'label'=>Mage::helper('buyerssurvey')->__('Disabled')),
            array('value' => 'large', 'label'=>Mage::helper('buyerssurvey')->__('Large (125x73 pixels)')),
            array('value' => 'small', 'label'=>Mage::helper('buyerssurvey')->__('Small (112x37 pixels)')),

        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray(array $arrAttributes = Array())
    {
        return array(
            '0' => Mage::helper('buyerssurvey')->__('None'),
            'footer' => Mage::helper('buyerssurvey')->__('Footer'),
            //'header' => Mage::helper('buyerssurvey')->__('Header'),
        //    'header' => Mage::helper('buyerssurvey')->__('Header'),
            'left' => Mage::helper('buyerssurvey')->__('Left'),
            'right' => Mage::helper('buyerssurvey')->__('Right Column'),
        );
    }

}
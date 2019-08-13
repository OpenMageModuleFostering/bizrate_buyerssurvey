<?php

class Bizrate_Buyerssurvey_Model_System_Config_Source_Position extends Mage_Core_Block_Template
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'footer', 'label'=>Mage::helper('buyerssurvey')->__('Footer')),
            array('value' => 'left', 'label'=>Mage::helper('buyerssurvey')->__('Left Column')),
            array('value' => 'right', 'label'=>Mage::helper('buyerssurvey')->__('Right Column')),
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
            'footer' => Mage::helper('buyerssurvey')->__('Footer'),
            'left' => Mage::helper('buyerssurvey')->__('Left Column'),
            'right' => Mage::helper('buyerssurvey')->__('Right Column'),
        );
    }

}

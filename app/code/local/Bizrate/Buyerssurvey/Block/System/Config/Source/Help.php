<?php

class Bizrate_Buyerssurvey_Block_System_Config_Source_Help
    extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{


    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        mage::log(__METHOD__);
        $useContainerId = $element->getData('use_container_id');
        $mid = Mage::getStoreConfig('buyerssurvey/buyerssurvey/mid');

        $label = ' <a href="mailto:bizrateinsights@bizrate.com?subject=Bizrate Buyers Survey assistance – Magento Enterprise__MID__">bizrateinsights@bizrate.com</a>.';

	$replace = '';
        if($mid)
        {
            $replace = ' MID - '.$mid;
        }
	
        $label = str_replace('__MID__',$replace,$label);

        $label = $element->getLabel() . $label;

        return sprintf('<tr class="system-fieldset-sub-head" id="row_%s"><td colspan="5"><h4 id="%s">%s</h4></td></tr>',
            $element->getHtmlId(), $element->getHtmlId(), $label
        );
    }


}

<?php

class Bizrate_Buyerssurvey_Block_System_Config_Source_Signup
    extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    
    /**
     * Set template to itself
     */
    protected function _prepareLayout()
    {
        
        parent::_prepareLayout();
        
        if (!$this->getTemplate()) {
            
            $this->setTemplate('buyerssurvey/system/config/signup.phtml');
            
        }
        
        return $this;
        
    }

    
    /**
     * Unset some non-related element parameters
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        
        return parent::render($element);
        
    }

    
    /**
     * Get the button and scripts contents
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        
        $originalData = $element->getOriginalData();

        $this->addData(array(
            'button_label' => Mage::helper('buyerssurvey')->__($originalData['button_label']),
            'html_id' => $element->getHtmlId(),
           // 'endpoint' => $this->getUrl('adminhtml/signup/update')
        ));
        
        return $this->_toHtml();
        
    }
    
}

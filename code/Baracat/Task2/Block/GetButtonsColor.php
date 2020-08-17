<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Baracat\Task2\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;


class GetButtonsColor extends \Magento\Framework\View\Element\Template
{
    private $scopeConfig;
    const XML_PATH_COLOR = 'buttons_color/buttons_color/btn_color';


    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function buttons_color()
    {
        $storeId = $this->_storeManager->getStore()->getStoreId();
       echo  $color =  $this->scopeConfig->getValue(self::XML_PATH_COLOR, $scope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        $this->_storeManager->getStore()->getStoreId());

        return __('storeId: %1 | scope: %2 |color: %3', $storeId , $scope, $color );
        
    }

    /**
     * @return string
     */
    public function get_color()
    {
        $color = str_replace("#", "",$this->scopeConfig->getValue(self::XML_PATH_COLOR, $scope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->_storeManager->getStore()->getStoreId()));

        if(strlen($color)>2){
            return  '#'.$color;
        }else {
            return false;
        }
        
    }



}
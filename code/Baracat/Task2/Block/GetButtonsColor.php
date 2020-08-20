<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Baracat\Task2\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Element\Template\Context;

class GetButtonsColor extends \Magento\Framework\View\Element\Template
{
    private $scopeConfig;
    const XML_PATH_COLOR = "buttons_color/buttons_color/btn_color";

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Context $context,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getColor()
    {
        $color = $this->scopeConfig->getValue(self::XML_PATH_COLOR, ScopeInterface::SCOPE_STORE, $this->_storeManager->getStore()->getStoreId());
        return  $color;
    }
}
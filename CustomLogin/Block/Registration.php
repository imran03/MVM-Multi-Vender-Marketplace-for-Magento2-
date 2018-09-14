<?php

namespace Codilar\CustomLogin\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Registration extends Template
{
    /**
     * Registration constructor.
     * @param Context $context
     * @param \Codilar\CustomLogin\Model\Config\Source\IsVendorOptions $isVendorOptions
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Codilar\CustomLogin\Model\Config\Source\CustomerYesNoOptions $isVendorOptions,
        array $data
    )
    {
        $this->isVendorOptions = $isVendorOptions;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     *
     */
    public function getIsVendorHTML()
    {
        //todo:: create is vendor dropdown html
    }
}
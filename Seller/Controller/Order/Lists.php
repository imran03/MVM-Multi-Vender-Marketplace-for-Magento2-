<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 29/8/18
 * Time: 5:46 PM
 */

namespace Codilar\Seller\Controller\Order;


class Lists extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }
}

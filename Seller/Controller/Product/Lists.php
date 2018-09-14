<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 29/8/18
 * Time: 1:32 PM
 */

namespace Codilar\Seller\Controller\Product;


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
        $this->_view->loadLayout();
        $this->_view->renderLayout();

    }
}
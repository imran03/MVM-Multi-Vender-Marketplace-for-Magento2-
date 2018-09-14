<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 24/8/18
 * Time: 10:58 AM
 */

namespace Codilar\Seller\Controller\Adminhtml\Lists;


class Index  extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Seller')));

        return $resultPage;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 2/9/18
 * Time: 2:19 PM
 */

namespace Codilar\Seller\Controller\Homepage;



class Profile extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $request;
    protected $_sellerProfileResource;
    protected $_profileFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Codilar\Seller\Model\ResourceModel\SellerProfile $sellerProfile,
        \Codilar\Seller\Model\SellerProfileFactory $profileFactory,
        \Magento\Framework\App\Request\Http $request)
    {
        $this->_pageFactory = $pageFactory;
        $this->request = $request;
        $this->_sellerProfileResource = $sellerProfile;
        $this->_profileFactory=$profileFactory;
        return parent::__construct($context);
    }

    public function execute()
    {


        return $this->_pageFactory->create();
    }
}

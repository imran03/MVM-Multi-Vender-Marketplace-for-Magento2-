<?php


namespace Codilar\CustomLogin\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use \Magento\Catalog\Model\CategoryLinkRepository;
use Magento\Customer\Api\AddressRepositoryInterface;
use Codilar\Seller\Model\ResourceModel\SellerProfile\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\AlreadyExistsException;

/**
 * Codilar Marketplace AdminhtmlCustomerSaveAfterObserver Observer.
 */
class AdminhtmlCustomerSaveAfterObserver implements ObserverInterface
{

    protected $_customerCollectionFactory;
    protected $_sellerCollectionFactory;
    protected $_objectManager;
    protected $customerRepositoryInterface;
    protected $customerAddressRepositoryInterface;
    protected $logger;

    public function __construct (
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Codilar\Seller\Model\ResourceModel\SellerProfile\CollectionFactory $sellerCollectionFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Customer\Api\AddressRepositoryInterface $customerAddressRepositoryInterface,
        \Psr\Log\LoggerInterface $loggerInterface
    )
    {
        $this->_objectManager = $objectManager;
        $this->_customerCollectionFactory = $customerCollectionFactory;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->customerAddressRepositoryInterface = $customerAddressRepositoryInterface;
        $this->_sellerCollectionFactory = $sellerCollectionFactory;
        $this->_date = $date;
        $this->logger = $loggerInterface;
    }


    public function execute (\Magento\Framework\Event\Observer $observer)
    {

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test1.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('before execute obserer');


        $customer = $observer->getCustomer ();
        $this->logger->debug($customer->getFirstName());
        $customerId=(int)$customer->getId();
        $customerEmail=$customer->getEmail();
        $customerName=$customer->getFirstName();


        $logger->info('before execute obserer111');
        $model = $this->_objectManager->create(
            'Codilar\Seller\Model\Seller');
        $isApprovedAccount = $customer->getCustomAttribute('approve_account')->getValue();
        if($isApprovedAccount == 1)
        {
            $model->setData('seller_id',$customerId);
            $model->setData('seller_email',$customerEmail);
            $model->setData('seller_name',$customerName);
//            $customer = $this->customerRepositoryInterface->getById($customerId);
//            $billingAddressId = $customer->getDefaultBilling();
//            $billingAddress = $this->customerAddressRepositoryInterface->getById($billingAddressId);
//            $telephone = $billingAddress->getTelephone();
//            if($telephone)
//            {
//                $model->setData ('phone', $telephone);
//            }
            $model->setData('seller_status',$isApprovedAccount);
            $model->setData('created_at',$this->_date->gmtDate());
            $logger->info('before execute obserer111');
            $model->save();
            $model = $this->_objectManager->create(
                'Codilar\Seller\Model\Commission');
            $model->setData('seller_id',$customerId);
            $model->setData('seller_name',$customerName);
            $model->save();
        }




}


}
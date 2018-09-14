<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 29/8/18
 * Time: 10:44 AM
 */

namespace Codilar\Seller\Block;
use \Codilar\CustomLogin\Helper\Vendor;
use \Codilar\Seller\Model\SellerProfile;


class Profile  extends \Magento\Framework\View\Element\Template
{
    protected $_helperData;
    protected $_sellerProfile;
    protected $_customerSession;

    /**
     * Profile constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param Vendor $helperData
     * @param SellerProfile $profileFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Vendor $helperData,
        SellerProfile $profileFactory,
        \Magento\Customer\Model\Session $customerSession,

        array $data = [])
    {
        $this->_helperData = $helperData;
        parent::__construct($context, $data);
        $this->_sellerProfile=$profileFactory;
        $this->_customerSession = $customerSession;
    }



    public function getFormAction()
    {
        return $this->getUrl ('seller/Profile/index');

    }


    public function getCustomerId()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test1.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($this->_customerSession->getCustomer()->getId ());
        return $this->_customerSession->getCustomer()->getId ();
    }

    public function getProfileData()
    {   $id=$this->_customerSession->getCustomer()->getId ();
        $profile=$this->_sellerProfile->load($id,'seller_id');
        return $profile;
    }


    public function getImagePath()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $imagePath = $objectManager->get('Magento\Store\Model\StoreManagerInterface')
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $imagePath ;
    }

    /**
     *
     *
     * @return mixed
     */
    public function getSliderImage()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $imagePath = $objectManager->get('Magento\Store\Model\StoreManagerInterface')
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $imagePath ;
    }
}
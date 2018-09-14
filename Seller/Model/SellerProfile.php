<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 2/9/18
 * Time: 12:56 AM
 */

namespace Codilar\Seller\Model;
use Codilar\Seller\Api\Data\ProfileInterface;


class SellerProfile  extends \Magento\Framework\Model\AbstractModel implements ProfileInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'marketplace_seller_profile';

    /**
     * @var string
     */
    protected $_cacheTag = 'marketplace_seller_profile';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'marketplace_seller_profile';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Codilar\Seller\Model\ResourceModel\SellerProfile');
    }

    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }


    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }


    public function getSellerId()
    {
        return $this->getData(self::SELLER);
    }

    public function setSellerId($sellerId)
    {
        return $this->setData(self::SELLER, $sellerId);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }
    public function setName($sellerName)
    {
        return $this->setData(self::NAME, $sellerName);
    }

    public function getShopURl()
    {
        return $this->getData(self::SHOPURL);
    }

    public function setShopURl($shopUrl)
    {
        return $this->setData(self::SHOPURL, $shopUrl);
    }


    public function getShopImage()
    {
        return $this->getData(self::SHOPIMAGE);
    }


    public function setShopImage($shopImage)
    {
        return $this->setData(self::SHOPIMAGE, $shopImage);
    }


    public function getAboutUs()
    {
        return $this->getData(self::ABOUTUS);
    }

    public function setAboutUs($aboutUs)
    {
        return $this->setData(self::ABOUTUS, $aboutUs);
    }

    public function getPayment()
    {
        return $this->getData(self::PAYMENT);

    }

    public function setPayment($payment)
    {
        return $this->setData(self::PAYMENT, $payment);
    }

    public function getReturnPolicy()
    {
        return $this->getData(self::RETURNPOLICY);
    }

    public function setReturnPolicy($returnPolicy)
    {
        return $this->setData(self::RETURNPOLICY, $returnPolicy);
    }


    public function getShippingPolicy()
    {
        return $this->getData(self::SHIPPING);
    }

    public function setShippingPolicy($shippingPolicy)
    {
        return $this->setData(self::SHIPPING, $shippingPolicy);
    }


    public function getCountry()
    {
        return $this->getData(self::COUNTRY);
    }

    public function setCountry($country)
    {
        return $this->setData(self::COUNTRY,$country);
    }




}
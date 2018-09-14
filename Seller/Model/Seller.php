<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 24/8/18
 * Time: 1:26 AM
 */

namespace Codilar\Seller\Model;
use Codilar\Seller\Api\Data\SellerInterface;

class Seller  extends \Magento\Framework\Model\AbstractModel implements SellerInterface
{

    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'marketplace_seller';

    /**
     * @var string
     */
    protected $_cacheTag = 'marketplace_seller';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'marketplace_seller';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Codilar\Seller\Model\ResourceModel\Seller');
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


    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }


    public function setEmail($sellerEmail)
    {
        return $this->setData(self::EMAIL, $sellerEmail);
    }

    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }


    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::STATUS);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED, $createdAt);
    }
}
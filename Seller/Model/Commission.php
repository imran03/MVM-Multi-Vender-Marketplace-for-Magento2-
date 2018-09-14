<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 25/8/18
 * Time: 12:09 PM
 */

namespace Codilar\Seller\Model;
use  \Codilar\Seller\Api\Data\CommissionInterface;

class Commission extends \Magento\Framework\Model\AbstractModel implements CommissionInterface
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
        $this->_init('Codilar\Seller\Model\ResourceModel\Commission');
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


    /**
     * @return mixed
     */
    public function getCommissionRate()
    {
        return $this->getData(self::COMMISSION_RATE);
    }

    /**
     * @param $commissionRate
     * @return mixed
     */
    public function setCommissionRate($commissionRate)
    {
        return $this->setData(self::COMMISSION_RATE, $commissionRate);
    }

    /**
     * @return mixed
     */
    public function getTotalSale()
    {
        return $this->getData(self::TOTAL_SALE);
    }

    /**
     * @param $totalSale
     * @return mixed
     */
    public function setTotalSale($totalSale)
    {
        return $this->setData(self::TOTAL_SALE, $totalSale);
    }

    /**
     * @return mixed
     */
    public function getAmountReceived()
    {
        return $this->getData(self::AMOUNT_RECEIVED);
    }

    /**
     * @param $amountReceived
     * @return mixed
     */
    public function setAmountReceived($amountReceived)
    {
        return $this->setData(self::AMOUNT_RECEIVED, $amountReceived);
    }

    /**
     * @return mixed
     */
    public function getCommissionAmount()
    {
        return $this->getData(self::COMMISSION_AMOUNT);
    }

    /**
     * @param $CommissionAmount
     * @return mixed
     */
    public function setCommissionAmount($commissionAmount)
    {
        return $this->setData(self::COMMISSION_AMOUNT, $commissionAmount);
    }

    /**
     * @return mixed
     */
    public function getAmountPaid()
    {
        return $this->getData(self::AMOUNT_PAID);
    }

    /**
     * @param $amountPaid
     * @return mixed
     */
    public function setAmountPaid($amountPaid)
    {
        return $this->setData(self::AMOUNT_PAID, $amountPaid);
    }



}
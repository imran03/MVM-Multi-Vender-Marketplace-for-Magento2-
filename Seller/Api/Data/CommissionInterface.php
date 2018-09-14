<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 25/8/18
 * Time: 10:02 AM
 */

namespace Codilar\Seller\Api\Data;



interface CommissionInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';
    const SELLER = 'seller_id';
    const NAME = 'seller_name';
    const COMMISSION_RATE = 'commission_rate';
    const TOTAL_SALE = 'total_sale';
    const AMOUNT_RECEIVED = 'received_amount';
    const COMMISSION_AMOUNT = 'commission_amount';
    const AMOUNT_PAID = 'amount_paid';

    /**
     * @return mixed
     */
    public function getEntityId();

    /**
     * @param $entityId
     * @return mixed
     */
    public function setEntityId($entityId);

    /**
     * @return mixed
     */

    public function getSellerId();

    /**
     * @param $sellerId
     * @return mixed
     */
    public function setSellerId($sellerId);

    /**
     * @return mixed
     */

    public function getName();

    /**
     * @param $sellerName
     * @return mixed
     */

    public function setName($sellerName);

    /**
     * @return mixed
     */
    public function getCommissionRate();

    /**
     * @param $commissionRate
     * @return mixed
     */
    public function setCommissionRate($commissionRate);

    /**
     * @return mixed
     */
    public function getTotalSale();

    /**
     * @param $totalSale
     * @return mixed
     */
    public function setTotalSale($totalSale);

    /**
     * @return mixed
     */
    public function getAmountReceived();

    /**
     * @param $amountReceived
     * @return mixed
     */
    public function setAmountReceived($amountReceived);

    /**
     * @return mixed
     */
    public function getCommissionAmount();

    /**
     * @param $CommissionAmount
     * @return mixed
     */
    public function setCommissionAmount($commissionAmount);

    /**
     * @return mixed
     */
    public function getAmountPaid();

    /**
     * @param $amountPaid
     * @return mixed
     */
    public function setAmountPaid($amountPaid);

}
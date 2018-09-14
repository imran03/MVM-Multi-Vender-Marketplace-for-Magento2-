<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 19/8/18
 * Time: 2:10 AM
 */

namespace Codilar\Seller\Api\Data;



interface SellerInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';
    const SELLER = 'seller_id';
    const NAME = 'seller_name';
    const EMAIL = 'seller_email';
    const STATUS = 'seller_status';
    const PHONE = 'phone';
    const CREATED_AT = 'created_at';


    public function getEntityId();


    public function setEntityId($entityId);


    public function getSellerId();


    public function setSellerId($sellerId);


    public function getName();


    public function setName($sellerName);


    public function getEmail();

    public function setEmail($sellerEmail);


    public function getStatus();


    public function setStatus($status);


    public function getCreatedAt();


    public function setCreatedAt($createdAt);
}
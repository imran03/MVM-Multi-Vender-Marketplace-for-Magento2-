<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 2/9/18
 * Time: 12:43 AM
 */

namespace Codilar\Seller\Api\Data;

interface ProfileInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';
    const SELLER = 'seller_id';
    const NAME = 'seller_name';
    const SHOPURL = 'shop_url';
    const SHOPIMAGE = 'shop_image';
    const ABOUTUS = 'about_us';
    const PAYMENT = 'payment_information';
    const RETURNPOLICY = 'return_policy';
    const SHIPPING = 'shipping_policy';
    const COUNTRY = 'country';


    public function getEntityId();


    public function setEntityId($entityId);


    public function getSellerId();


    public function setSellerId($sellerId);


    public function getName();


    public function setName($sellerName);


    public function getShopURl();

    public function setShopURl($shopUrl);


    public function getShopImage();


    public function setShopImage($shopImage);


    public function getAboutUs();

    public function setAboutUs($aboutUs);

    public function getPayment();

    public function setPayment($payment);

    public function getReturnPolicy();

    public function setReturnPolicy($returnPolicy);


    public function getShippingPolicy();

    public function setShippingPolicy($shippingPolicy);


    public function getCountry();

    public function setCountry($country);

}






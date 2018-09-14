<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 2/9/18
 * Time: 1:11 AM
 */

namespace Codilar\Seller\Model\ResourceModel\SellerProfile;


class Collection  extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Codilar\Seller\Model\SellerProfile', 'Codilar\Seller\Model\ResourceModel\SellerProfile');
    }


}
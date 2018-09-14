<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 24/8/18
 * Time: 10:12 AM
 */

namespace Codilar\Seller\Model\ResourceModel\Commission;


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
        $this->_init('Codilar\Seller\Model\Commission', 'Codilar\Seller\Model\ResourceModel\Commission');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 2/9/18
 * Time: 11:14 PM
 */

namespace Codilar\Seller\Block;
use \Codilar\Seller\Model\Commission;

class CommissionList extends \Magento\Framework\View\Element\Template
{
    protected $customerSession;
    protected $_commissionFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Codilar\Seller\Model\CommissionFactory $commissionFactory,
        \Magento\Customer\Model\Session $customerSession,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_commissionFactory=$commissionFactory;
        $this->customerSession = $customerSession;
    }

    public function getCommission()
    {
        $Id =  $this->customerSession->getCustomer ()->getId ();
        $model=$this->_commissionFactory->create()->load($Id,'seller_id');
//        return $Id;
         return $model;
    }
}
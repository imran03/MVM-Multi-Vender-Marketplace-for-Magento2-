<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 30/8/18
 * Time: 11:00 PM
 */

namespace Codilar\Seller\Observer;
use Magento\Framework\Event\ObserverInterface;


class SalesOrderSaveAfter implements ObserverInterface {

    protected $_commission;
    protected $_customerSession;
    protected $_product;
    protected $orderRepository;

    public function __construct(
        \Codilar\Seller\Model\CommissionFactory $commissionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\OrderRepository $orderRepository,
        \Magento\Catalog\Model\ProductFactory $productFactory
    )
    {
        $this->_commission=$commissionFactory;
        $this->orderRepository = $orderRepository;
        $this->_customerSession = $customerSession;
        $this->_product = $productFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();
        if($order->getState() == 'complete') {

            $order=$this->orderRepository->get($order->getId());
            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test1.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
            $logger->info($order->getState());
            $logger->info($order->getId());
            $logger->info($order->getIncrementId());
            foreach ($order->getAllItems() as $item) {

                $pid=$item->getProductId();
                $logger->info($pid);

            }

            $product =  $this->_product->create()->load($pid);
            $vendorId=$product->getVendorId();
            $logger->info("vendorId".$vendorId);
            $commission=$this->_commission->create()->getCollection()
                ->addFieldToFilter('seller_id', $vendorId);


            $commissionRate=$commission->getFirstItem()->getCommissionRate();

            $logger->info($commission->getFirstItem()->getCommissionRate().$order->getGrandTotal());

            $totalAmount=$commission->getFirstItem()->getTotalSale();
            $newAmount=$totalAmount+$order->getGrandTotal();
            $logger->info("new amount".$newAmount);

            $commissionAmount=$commission->getFirstItem()->getCommissionAmount();

            $newCommissionAmount=$order->getGrandTotal()*($commissionRate/100);

            $updatecommissionAmount=$newCommissionAmount+$commissionAmount;
            $logger->info("update commission".$updatecommissionAmount);

            $commissionrecieved=$commission->getFirstItem()->getReceivedAmount();
            $commissionAmountpaid=$commission->getFirstItem()->getAmountPaid();
            $newCommissionAmountPaid=$commissionrecieved-$commissionAmountpaid;

            $commission->getFirstItem()->setTotalSale($newAmount);
            $commission->getFirstItem()->setCommissionAmount($updatecommissionAmount);
            $commission->getFirstItem()->setAmountPaid ($newCommissionAmountPaid);
            if( $commission->save ())
            {
                $logger->info("update commission success");
            }
            else{
                $logger->info("not update commission success");
            }
        }

    }
}
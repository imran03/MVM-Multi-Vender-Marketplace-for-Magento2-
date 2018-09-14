<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 30/8/18
 * Time: 3:27 PM
 */

namespace Codilar\Seller\Controller\Order;


use Magento\Framework\App\Action\Context;

class OrderShip  extends \Magento\Framework\App\Action\Action
{

    protected $_order;
    protected  $_convertedOrder;
    protected $_shipNotification;
     public function __construct (
         Context $context,
         \Magento\Framework\App\Request\Http $request,
         \Magento\Sales\Model\Convert\Order $converttOrder,
         \Magento\Framework\View\Result\PageFactory $pageFactory,
         \Magento\Shipping\Model\ShipmentNotifier $shipmentNotifier,
         \Magento\Sales\Model\Order $oorder)
    {
        $this->request = $request;
        $this->_order =$oorder;
        $this->_pageFactory = $pageFactory;
        $this->_convertedOrder=$converttOrder;
        $this->_shipNotification=$shipmentNotifier;
        parent::__construct ( $context );
    }

    public function execute ()
    {
        // TODO: Implement execute() method.
        $params=$this->request->getParams();
        $orderId = $params["param"];
        $order=$this->_order->loadByIncrementID($orderId);

        if (! $order->canShip()) {
            $this->messageManager->addErrorMessage ('shipment already done !');
            $redirect = $this->resultRedirectFactory->create();
            $redirect->setPath ('seller/order/lists');
            return $redirect;
        }

        $convertOrder = $this->_convertedOrder;
        $shipment = $convertOrder->toShipment($order);

        // Loop through order items
        foreach ($order->getAllItems() AS $orderItem) {
            // Check if order item has qty to ship or is virtual
            if (! $orderItem->getQtyToShip() || $orderItem->getIsVirtual()) {
                continue;
            }

            $qtyShipped = $orderItem->getQtyToShip();

            // Create shipment item with qty
            $shipmentItem = $convertOrder->itemToShipmentItem($orderItem)->setQty($qtyShipped);

            // Add shipment item to shipment
            $shipment->addItem($shipmentItem);
        }
        $shipment->register();

        $shipment->getOrder()->setIsInProcess(true);

        try {
            // Save created shipment and order
            $shipment->save();
            $shipment->getOrder()->save();

            // Send email
            $this->_shipNotification->notify($shipment);

            $shipment->save();
            $this->messageManager->addSuccessMessage ('shipment done !');
            $redirect = $this->resultRedirectFactory->create();
            $redirect->setPath ('seller/order/lists');
            return $redirect;


        } catch (\Exception $e) {


            $this->messageManager->addErrorMessage ('shipment already done !');
            $redirect = $this->resultRedirectFactory->create();
            $redirect->setPath ('seller/order/lists');
            return $redirect;

        }

    }
}
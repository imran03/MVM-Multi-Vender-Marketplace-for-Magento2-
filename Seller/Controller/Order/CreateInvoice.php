<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 30/8/18
 * Time: 11:05 AM
 */

namespace Codilar\Seller\Controller\Order;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;

class CreateInvoice extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $_orderRepository;
    protected $_invoiceSender;

    /**
     * @var \Magento\Sales\Model\Service\InvoiceService
     */
    protected $_invoiceService;
    protected $request;
    protected $_orderCollectionFactory;
    /**
     * @var \Magento\Framework\DB\Transaction
     */

    protected $searchCriteriaBuilder;
    protected $_transaction;
    protected $order;
    protected $_orderInterface;
    public function __construct (
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Sales\Model\Order $order,
        InvoiceSender $invoiceSender,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Sales\Api\Data\OrderInterface $orderInterface,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Sales\Model\Service\InvoiceService $invoiceService,
        \Magento\Framework\DB\Transaction $transaction
    )
    {
        $this->_orderRepository = $orderRepository;
        $this->_invoiceService = $invoiceService;
        $this->order = $order;
        $this->_invoiceSender = $invoiceSender;
        $this->request = $request;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_orderInterface=$orderInterface;
        $this->_pageFactory = $pageFactory;
        $this->_orderCollectionFactory = $order;
        $this->_transaction = $transaction;
        parent::__construct ( $context );
    }

    /**
     * Marketplace order invoice controller.
     *
     * @return \Magento\Framework\View\Result\Page
     */

    public function execute ()
    {
        $param = $this->request->getParams("param");
        $orderId=$param['param'];
        $orderdetails = $this->order->loadByIncrementId ( $orderId );

        foreach ($orderdetails->getAllItems() as $item)
        {
            $qty = $item->getQtyOrdered();
            $item = $item->getItemId();

        }

        $order = $this->_orderRepository->get( $orderId );

        if ($order->canInvoice ()) {
            $itemsArray = [$item => $qty]; //here 80 is order item id and 2 is it's quantity to be invoice
            $shippingAmount = $orderdetails->getShippingAmount () ;
            $subTotal = $orderdetails->getSubTotal ();
            $baseSubtotal = $orderdetails->getGrandTotal ();
            $grandTotal = $orderdetails->getGrandTotal ();
            $baseGrandTotal = $orderdetails->getBaseGrandTotal ();
            $invoice = $this->_invoiceService->prepareInvoice ( $order, $itemsArray );
            $invoice->setShippingAmount ( $shippingAmount );
            $invoice->setSubtotal ( $subTotal );
            $invoice->setBaseSubtotal ( $baseSubtotal );
            $invoice->setGrandTotal ( $grandTotal );
            $invoice->setBaseGrandTotal ( $baseGrandTotal );
            $invoice->register ();
            $transactionSave = $this->_transaction->addObject (
                $invoice
            )->addObject (
                $invoice->getOrder ()
            );

            $transactionSave->save ();

            if (!$invoice->getEmailSent ()) {
                try {
                    $this->_invoiceSender->send ( $invoice );
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage ( 'email not send !' );
                }

            }

            //send notification code
            $order->addStatusHistoryComment (
                __ ( 'Notified customer about invoice #%1.', $invoice->getId () )
            )
                ->setIsCustomerNotified ( true )
                ->save ();

        }
        $redirect = $this->resultRedirectFactory->create ();
        $redirect->setPath ( 'seller/order/lists' );
        return $redirect;
    }


}
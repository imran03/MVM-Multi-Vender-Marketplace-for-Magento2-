<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 29/8/18
 * Time: 5:45 PM
 */

namespace Codilar\Seller\Block\Order;



use Magento\Framework\View\Element\Template;

class Lists extends \Magento\Framework\View\Element\Template
{
    protected $_order;
    protected $_orderModel;
    protected $_customerSession;
    protected $_product;
    protected $collection;
    protected $orderRepository;
    protected $_orderCollectionFactory;
    protected $searchCriteriaBuilder;
    public function __construct (
        Template\Context $context,
        \Magento\Sales\Model\Order $orderFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $order,

        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Sales\Model\OrderRepository $orderRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        array $data = [])
    {
        parent::__construct ( $context, $data );
        $this->_order  = $order;
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->customerSession = $customerSession;
        $this->_objectManager = $objectManager;
        $this->_product = $productFactory;
        $this->orderFactory = $orderFactory;
        $this->_orderCollectionFactory=$order;



    }



    public function getOrders()
    {
        //get values of current page. If not the param value then it will set to 1
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 3;
        //get values of current limit. If not the param value then it will set to 1
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 4;
        $collection = $this->_orderCollectionFactory->create ();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }


    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Order List'));
        if ($this->getOrders()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'seller.order.lists.pager'
            )->setAvailableLimit(array(5=>5,10=>10,15=>15))->setShowPerPage(true)->setCollection(
                $this->getOrders()
            );
            $this->setChild('pager', $pager);
            $this->getOrders()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }


     public function getproductId()
     {


         $collection = $this->_orderCollectionFactory->create ();
            foreach ($collection as $order) {
             foreach ($order->getAllItems() as $item) {
                 $orders['items'][] = array(
                     'id'            => $order->getIncrementId(),
                     'itemId'        => $item->getItemId(),
                     'orderId'         =>$item->getOrderId(),
                     'name'          => $item->getName(),
                     'product_id'     =>$item->getProductId(),
                     'created_at'     =>$item->getCreatedAt(),
                     'sku'           => $item->getSku(),
                     'price'         => $item->getPrice(),
                     'ordered Qty'   => $item->getQtyOrdered(),
                 );
             }
         }

            return $orders;




     }

    public function getOrderById($id) {
        return $this->orderRepository->get($id);
    }




    public function isVendorId($pid)
    {
        $product =  $this->_product->create()->load($pid);
        $vendorid=$product->getVendorId();
        return $vendorid;
    }

    public function getcustomerId()
    {
        $customerId =  $this->customerSession->getCustomer ()->getId ();
        return $customerId;
    }


}
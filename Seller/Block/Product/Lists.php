<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 29/8/18
 * Time: 1:59 PM
 */

namespace Codilar\Seller\Block\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use \Magento\Catalog\Helper\Image;
use \Magento\Catalog\Model\Product;
class Lists  extends \Magento\Framework\View\Element\Template
{
    protected $_collection;
    protected $_customerSession;
    protected $_imageBuilder;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Catalog\Block\Product\ImageBuilder $_imageBuilder,
        \Magento\Catalog\Helper\Image $productImageHelper,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_objectManager = $objectManager;
        $this->customerSession = $customerSession;
        $this->_stockItemRepository = $stockItemRepository;
        $this->_imageBuilder=$_imageBuilder;
        $this->_productImageHelper = $productImageHelper;
        $this->formKey = $context->getFormKey();
        $this->_collection = $collectionFactory;
    }



    public function getCustomerId()
    {
        $customerId = $this->customerSession->getCustomer ()->getId ();
        return $customerId;
    }

    public function getProductList()
    {    $customerId = $this->customerSession->getCustomer ()->getId ();
        $id=$customerId;
        $collection = $this->_collection->create ();
        $productcollection = $collection->addAttributeToSelect ( '*' )->addAttributeToFilter (
            [['attribute' => 'vendor_id', 'eq' =>$id ]] );
        return $productcollection;
    }
    public function getProducts()
    {
        //get values of current page. If not the param value then it will set to 1
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 3;
        //get values of current limit. If not the param value then it will set to 1
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 4;
        $customerId = $this->customerSession->getCustomer ()->getId ();
        $id=$customerId;
        $collection = $this->_collection->create ();
        $productcollection = $collection->addAttributeToSelect ( '*' )->addAttributeToFilter (
            [['attribute' => 'vendor_id', 'eq' =>$id ]] );
        $productcollection->setPageSize($pageSize);
        $productcollection->setCurPage($page);
        return $productcollection;
    }
    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Product List'));
        if ($this->getProducts()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'seller.product.lists.pager'
            )->setAvailableLimit(array(5=>5,10=>10,15=>15))->setShowPerPage(true)->setCollection(
                $this->getProducts()
            );
            $this->setChild('pager', $pager);
            $this->getProducts()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function resizeImage($product, $imageId, $width, $height = null)
    {
        $resizedImage = $this->_productImageHelper
            ->init($product, $imageId)
            ->constrainOnly(TRUE)
            ->keepAspectRatio(TRUE)
            ->keepTransparency(TRUE)
            ->keepFrame(FALSE)
            ->resize($width, $height);
        return $resizedImage;
    }

    public function getImage($product, $imageId, $attributes = [])
    {
        return $this->_imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }

    public function getStockItem($productId)
    {
        return $this->_stockItemRepository->get($productId);
    }

}
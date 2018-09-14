<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 2/9/18
 * Time: 2:44 PM
 */

namespace Codilar\Seller\Block\Homepage;


class Profile  extends \Magento\Framework\View\Element\Template
{

    protected $_product;
    protected $_sellerProfileResource;
    protected $_profileFactory;
    protected $request;
    protected $_collection;
    protected $_imageBuilder;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Codilar\Seller\Model\ResourceModel\SellerProfile $sellerProfile,
        \Magento\Catalog\Block\Product\ImageBuilder $_imageBuilder,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Codilar\Seller\Model\SellerProfileFactory $profileFactory,

        \Magento\Framework\App\Request\Http $request)
    {
        parent::__construct($context);
        $this->request = $request;
        $this->_product = $productFactory;
        $this->_collection = $collectionFactory;
        $this->_imageBuilder=$_imageBuilder;
        $this->_sellerProfileResource = $sellerProfile;
        $this->_profileFactory=$profileFactory;
    }

    public function sayHello()
    {
        $param = $this->request->getParam("shop");
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test1.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($param);
        $model=$this->_profileFactory->create()->load($param,'shop_url');
        return $model;

    }


    public function getImagePath()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $imagePath = $objectManager->get('Magento\Store\Model\StoreManagerInterface')
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $imagePath ;
    }

    public function getProductData()
    {
        $param = $this->request->getParam("shop");
        $model=$this->_profileFactory->create()->load($param,'shop_url');
        $id=$model->getSellerId();
        $collection = $this->_collection->create ();
        $productcollection = $collection->addAttributeToSelect ( '*' )->addAttributeToFilter (
            [['attribute' => 'vendor_id', 'eq' =>$id ]] );
         $productcollection->setPageSize(3);
        return $productcollection;
    }

    public function getImage($product, $imageId, $attributes = [])
    {
        return $this->_imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }

    public function getSliderImage($product, $imageId, $attributes = [])
    {
        return $this->_imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 3/9/18
 * Time: 10:19 AM
 */

namespace Codilar\Seller\Controller\Product;


class Edit extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $request;
    protected $_stockRegistry;
    protected $_stockStateInterface;
    protected $_product;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Catalog\Model\Product $product,

        \Magento\CatalogInventory\Api\StockStateInterface $stockStateInterface,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\Framework\App\Request\Http $request)
    {
        $this->_pageFactory = $pageFactory;
        $this->request = $request;
        $this->_product = $product;
        $this->_stockStateInterface = $stockStateInterface;
        $this->_stockRegistry = $stockRegistry;
        return parent::__construct($context);
    }

    public function execute()
    {   $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter ($writer);
        $logger->info ('edit');

        if (!empty($_POST)  ) {

            $id=$_POST['id'];
            $productName = $_POST['product_name'];
            $sku = $_POST['sku'];
            $description = $_POST['description'];
            $shortDescription=$_POST['short_description'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
           // var_dump( $quantity);
            $category_id = array();
            $cat=isset($_POST['category']) ? $_POST['category'] : NULL;
            $sub=isset($_POST['subcategory']) ? $_POST['subcategory'] : NULL;


            if(!empty($cat))
                foreach($cat as $key)
                {
                    $category_id[]=$key;
                }
            if(!empty($sub)) {
                foreach ( $sub as $key ) {
                    $category_id[] = $key;
                    $logger->info ( $key );
                }
            }


          // $stockItem=$this->_stockRegistry->getStockItem('id');
            $stockItem = $this->_stockRegistry->getStockItem($id);

                echo $quantity;
            $product = $this->_product->load ( $id ); //load product which you want to update stock

            $product->setData ('sku',$sku); // Set your sku here
            $product->setData ('name',$productName); // Name of Product
            $product->setData('description',$description);
            $product->setData('short_description',$shortDescription);
            $product->setdata('price',$price);
            $product->setCategoryIds($category_id);
            $stockItem->setData('qty', $quantity);
            $stockItem->setData('is_in_stock',1); //set updated data as your requirement
            $stockItem->setData('qty',11); //set updated quantity
            $stockItem->setData('manage_stock',1);
            $stockItem->setData('use_config_notify_stock_qty',0);
            $product->setStockData(['qty' => $quantity, 'is_in_stock' => 1]);
            $product->setQuantityAndStockStatus(['qty' => $quantity, 'is_in_stock' => 1]);



            $product->save (); //  also save product
        }
        return $this->_pageFactory->create();
    }

}
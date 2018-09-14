<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 27/8/18
 * Time: 6:40 PM
 */

namespace Codilar\Seller\Controller\Product;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Customer\Model\Session;
use Magento\Catalog\Model\Product;
use \Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Output;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
class Save extends \Magento\Framework\App\Action\Action
{
    protected $customerSession;
    protected $_product;
    protected $_productRepostiory;
    protected $_filesystem;
    protected $_directorylist;

    public function __construct (
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        Session $customerSession,
        \Magento\Framework\Filesystem $fileSystem,
       \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->session = $customerSession;
        $this->_filesystem = $fileSystem;
        $this->_product = $productFactory;
        $this->_directorylist=$directoryList;
        $this->_productRepostiory = $productRepository;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        return parent::__construct ($context);
    }

    public function execute ()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter ($writer);
        $logger->info ('save');
        $product = $this->_product->create();
        $customerId = $this->session->getCustomerId ();
        $logger->info ($customerId);
        $post = (array)$this->getRequest ()->getPost ();

        if (!empty($post)  ) {

            $productName = $post['product_name'];
            $sku = $post['sku'];
            $description = $post['description'];
            $price = $post['price'];
            $quantity = $post['quantity'];
            $category_id = array();
            $cat=isset($_POST['category']) ? $_POST['category'] : NULL;;
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


            $product->setSku ($sku); // Set your sku here
            $product->setName ($productName); // Name of Product
            $product->setAttributeSetId (4); // Attribute set id
            $product->setStatus (1); // Status on product enabled/ disabled 1/0
            $product->setWebsiteIds(array(1));
            $product->setData ('vendor_id', $customerId);
            $product->setCategoryIds($category_id);
            $logger->info ($customerId);
            $product->setDescription($description);
            $product->setShortDescription($description);
            $product->setVisibility (4); // visibilty of product (catalog / search / catalog, search / Not visible individually)
            $product->setTaxClassId (0); // Tax class id
            $product->setTypeId ('simple'); // type of product (simple/virtual/downloadable/configurable)
            $product->setPrice ($price); // price of product
            $product->setStockData (
                array (
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'is_in_stock' => 1,
                    'qty' => $quantity
                )
            );
            $result = array ();
            if ($_FILES['test_image']['name']) {
                try {
                    // init uploader model.
                    $uploader = $this->_objectManager->create (
                        'Magento\MediaStorage\Model\File\Uploader',
                        ['fileId' => 'test_image']
                    );
                    $uploader->setAllowedExtensions (['jpg', 'jpeg', 'gif', 'png']);
                   // $uploader->setAllowRenameFiles (true);
                    $uploader->setFilesDispersion(false);
                    // get media directory
                    $mediaDirectory = $this->_filesystem->getDirectoryRead (DirectoryList::MEDIA);
                    $result = $uploader->save ($mediaDirectory->getAbsolutePath('catalog/product'));
                } catch (Exception $e) {
                    \Zend_Debug::dump ($e->getMessage ());
                }
            }
            $imagepath=$_FILES['test_image']['name'];

            $imagePath ="/catalog/product/".$imagepath;
            $product->addImageToMediaGallery($imagePath, array('image', 'small_image', 'thumbnail'), false, false);
            $product->save();
            $this->_productRepostiory->save ($product);
            $this->messageManager->addSuccessMessage ('product added done !');


            $resultRedirect = $this->resultFactory->create (ResultFactory::TYPE_REDIRECT);
            $redirect = $this->resultRedirectFactory->create ();
            $redirect->setPath ('seller/product/add');
            return $redirect;

            return $resultRedirect;
        } else {
            $this->messageManager->adderrorMessage ('product not added !');

        }
    }


}
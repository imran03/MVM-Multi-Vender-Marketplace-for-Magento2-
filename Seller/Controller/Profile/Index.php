<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 29/8/18
 * Time: 2:28 AM
 */

namespace Codilar\Seller\Controller\Profile;

use \Codilar\CustomLogin\Helper\Vendor;
use \Codilar\Seller\Model\SellerProfile;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
class Index  extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_sellerProfileFactory;
    protected $_fileUploaderFactory;
    protected $_filesystem;
    protected $_directoryList;
    protected $_helperData;

    public function __construct(

        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Codilar\Seller\Model\SellerProfileFactory $profileFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Codilar\CustomLogin\Helper\Vendor $helperData,
        \Magento\Framework\Filesystem $fileSystem)
    {
        $this->_helperData = $helperData;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_directoryList = $directoryList;
        $this->_pageFactory = $pageFactory;
        $this->_filesystem = $fileSystem;
        $this->_sellerProfileFactory =$profileFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        if(!empty($_POST)) {
            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test1.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);

            $sellerid = $_POST["seller_id"];
            $logger->info('seller id'.$sellerid);
            $sellername = $_POST["seller_name"];
            $customer = $this->_helperData->getShopUrl();
            $shopkey=$customer;
            $shopUrl = $shopkey;
            $logger->info( $shopUrl);

            $aboutUs = $_POST['about_us'];
            $paymentInformation = $_POST['payment_information'];
            $returnPolicy = $_POST['return_policy'];
            $shippingPolicy = $_POST['shipping_policy'];
            $country = $_POST['country'];
            $profile = $this->_sellerProfileFactory->create()->load($sellerid,'seller_id' );
            $profile->setData( 'seller_id', $sellerid );
            $profile->setData( 'seller_name', $sellername );
            $profile->setData ( 'shop_url', $shopUrl );

            //$result = array ();
            if(isset($_FILES['shop_image'])) {
                if ($_FILES['shop_image']['name']) {
                    try {
                        // init uploader model.
                        $uploader = $this->_objectManager->create (
                            'Magento\MediaStorage\Model\File\Uploader',
                            ['fileId' => 'shop_image']
                        );
                        $uploader->setAllowedExtensions ( ['jpg', 'jpeg', 'gif', 'png'] );
                        // $uploader->setAllowRenameFiles (true);
                        $uploader->setFilesDispersion ( false );
                        // get media directory
                        $mediaDirectory = $this->_filesystem->getDirectoryRead( DirectoryList::MEDIA );
                        $uploader->save ( $mediaDirectory->getAbsolutePath( "/images/" ) );
                    } catch (Exception $e) {
                        \Zend_Debug::dump ( $e->getMessage () );
                    }
                }
                $imagepath=$_FILES['shop_image']['name'];
                $imagePath ="/images/".$imagepath;
                //echo $imagePath;
                $profile->setData('shop_image',$imagePath);
            }
            else {

            }
            //$imagepath=$_FILES['test_image']['name'];

            $profile->setData ( 'payment_information', $paymentInformation );
            $profile->setData ( 'about_us', $aboutUs );
            $profile->setData ( 'return_policy', $returnPolicy );
            $profile->setData ( 'shipping_policy', $shippingPolicy );
            $profile->setData ( 'country', $country );
            $profile->save ();
        }


        return $this->_pageFactory->create();
    }
}
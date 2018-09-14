<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 13/3/18
 * Time: 5:51 PM
 */
namespace Codilar\Seller\Block;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class Soldby extends Template
{
    /**
     * @var Registry
     */
    private $registry;
    protected $_sellerFactory;

    /**
     * ImageDescription constructor.
     * @param Template\Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(

        Template\Context $context,
        Registry $registry,
        \Codilar\Seller\Model\SellerFactory $sellerFactory,
        array $data = []
    )
    {

        parent::__construct($context, $data);
        $this->_sellerFactory=$sellerFactory;
        $this->registry = $registry;
    }

    /**
     * @return mixed
     */
    public function getText() {
        /* @var \Magento\Catalog\Model\Product $product */

        
        $product = $this->registry->registry('current_product');
        $post = $product->getVendorId();
        $SellerModel=$this->_sellerFactory->create()->load($post,'seller_id');
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter ($writer);
        $logger->info ($SellerModel->getSellerName());
        return $SellerModel;

    }
}
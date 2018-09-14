<?php


namespace Codilar\Seller\Controller\Adminhtml\Lists;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Codilar\Seller\Model\SellerFactory
     */
    var $sellerFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Codilar\Seller\Model\SellerFactory $sellerFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Codilar\Seller\Model\SellerFactory $sellerFactory
    ) {
        parent::__construct($context);
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('seller/lists/addrow');
            return;
        }
        try {
            $rowData = $this->sellerFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setEntityId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('seller/lists/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Codilar_Seller::save');
    }
}
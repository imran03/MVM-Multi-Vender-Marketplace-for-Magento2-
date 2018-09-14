<?php


namespace Codilar\Seller\Controller\Adminhtml\Commission;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Codilar\Seller\Model\CommissionFactory
     */
    var $commissionFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Codilar\Seller\Model\CommissionFactory $commssionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Codilar\Seller\Model\CommissionFactory $commissionFactory
    ) {
        parent::__construct($context);
        $this->commissionFactory = $commissionFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('seller/commission/addrow');
            return;
        }
        try {
            $rowData = $this->commissionFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setEntityId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('seller/commission/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Codilar_Seller::save');
    }
}
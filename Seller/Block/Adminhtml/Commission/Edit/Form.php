<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 19/8/18
 * Time: 3:23 PM
 */

namespace Codilar\Seller\Block\Adminhtml\Commission\Edit;


class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Codilar\Seller\Model\Status $options,
        array $data = []
    )
    {
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                'id' => 'edit_form',
                'enctype' => 'multipart/form-data',
                'action' => $this->getData('action'),
                'method' => 'post'
            ]
            ]
        );

        $form->setHtmlIdPrefix('codilar_');
        if ($model->getEntityId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Row Data'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Row Data'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'seller_id',
            'text',
            [
                'name' => 'seller_id',
                'label' => __('Seller Id'),
                'id' => 'seller_id',
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'seller_name',
            'text',
            [
                'name' => 'seller_name',
                'label' => __('Seller Name'),
                'id' => 'seller_Name',
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'commission_rate',
            'text',
            [
                'name' => 'commission_rate',
                'label' => __('Commission Rate'),
                'id' => 'commission_Rate',
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'total_sale',
            'text',
            [
                'name' => 'total_sale',
                'label' => __('Total Sale'),
                'id' => 'total_sale',
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'received_amount',
            'text',
            [
                'name' => 'received_amount',
                'label' => __('Received Amount'),
                'id' => 'received_amount',
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'commission_amount',
            'text',
            [
                'name' => 'commission_amount',
                'label' => __('Commission Amount'),
                'id' => 'commission_amount',
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'amount_paid',
            'text',
            [
                'name' => 'amount_paid',
                'label' => __('Amount Paid'),
                'id' => 'amount_paid',
                'class' => 'required-entry',
                'required' => true,
            ]
        );




        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

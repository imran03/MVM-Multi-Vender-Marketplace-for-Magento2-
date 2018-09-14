<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 1/9/18
 * Time: 3:05 PM
 */

namespace Codilar\Seller\Setup;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;


class InstallData  implements InstallDataInterface
{


    const SHOP_URL = 'shop_url';
    private $eavSetupFactory;
    protected $customerSetupFactory;
    private $attributeSetFactory;
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig       = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        /**
         *  create customer attribute is_vendor
         */
        $customerSetup->addAttribute(Customer::ENTITY, self::SHOP_URL,
            [
                'type' => 'varchar',
                'label' => 'Shop Url',
                'input' => 'text',
                'required' => false,
                'default' => '0',
                'visible' => true,
                'user_defined' => true,
                'searchable' => true,
                'filterable' => true,
                'comparable' => true,
                'visible_on_front' => true,
                'sort_order' => 210,
                'position' => 210,
                'system' => false,
            ]);

        $shop_url = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::SHOP_URL)
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer','checkout_register','customer_account_create','customer_account_edit','adminhtml_checkout'],
            ]);

        $shop_url->save();
        $setup->endSetup();

    }
}

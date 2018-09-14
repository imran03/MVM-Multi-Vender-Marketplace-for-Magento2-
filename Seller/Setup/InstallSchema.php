<?php


namespace Codilar\Seller\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install (SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /*
         * Create table 'marketplace_seller'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('marketplace_seller'))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                'seller_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'seller id'
            )
            ->addColumn(
                'seller_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                40,
                ['unsigned' => true, 'nullable' => false],
                'seller name'
            )
            ->addColumn(
                'seller_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                40,
                ['unsigned' => true, 'nullable' => false],
                'seller email'
            )
            ->addColumn(
                'seller_status',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false],
                'seller status '
            )
            ->addColumn(
                'shop_url',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['unsigned' => true, 'nullable' => false],
                'seller shop url'
            )
            ->addColumn(
                'phone',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                20,
                ['unsigned' => true, 'nullable' => false],
                'Phone'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Creation Time'
            )
            ->setComment('Marketplace Seller Table');
        $installer->getConnection()->createTable($table);

        /**
         * marketplace commission
         */

        $table = $installer->getConnection()
            ->newTable($installer->getTable('marketplace_commission'))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )
            ->addColumn(
                'seller_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Seller Id'
            )
            ->addColumn(
                'seller_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Seller Name'
            )
            ->addColumn(
                'commission_rate',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                null,
                ['nullable' => true, 'default' => null],
                'Seller Commission Rate'
            )
            ->addColumn(
                'total_sale',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                255,
                ['nullable' => true, 'default' => null],
                'Total Seller Sale'
            )
            ->addColumn(
                'received_amount',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                255,
                ['nullable' => true, 'default' => null],
                'Seller Received Amount'
            )
            ->addColumn(
                'commission_amount',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                255,
                ['nullable' => true, 'default' => null],
                'Seller Commission Amount'
            )
            ->addColumn(
                'amount_paid',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                255,
                ['nullable' => true, 'default' => null],
                'Seller Commission Paid '
            )
            ->setComment('Marketplace Seller Commission Table');
        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()
            ->newTable($installer->getTable('marketplace_seller_profile'))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )
            ->addColumn(
                'seller_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Seller Id'
            )
            ->addColumn(
                'seller_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Seller Name'
            )
            ->addColumn(
                'shop_url',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => true, 'default' => null],
                'Seller shop url'
            )
            ->addColumn(
                'shop_image',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => true, 'default' => null],
                'Seller image'
            )
            ->addColumn(
                'about_us',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                800,
                ['nullable' => true, 'default' => null],
                'Seller About us'
            )
            ->addColumn(
                'payment_information',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => true, 'default' => null],
                'Seller payment information '
            )
            ->addColumn(
                'return_policy',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                500,
                ['nullable' => true, 'default' => null],
                'Seller return policy'
            )
            ->addColumn(
                'shipping_policy',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                500,
                ['nullable' => true, 'default' => null],
                'Seller Shipping policy '
            )
            ->addColumn(
                'country',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                20,
                ['nullable' => true, 'default' => null],
                'Seller Country '
            )
            ->setComment('Marketplace Seller profile Table');
        $installer->getConnection()->createTable($table);



    }
}
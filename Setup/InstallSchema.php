<?php

namespace CatalinMoiceanu\ScheduledPages\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'schedule_from',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                'unsigned' => true,
                'nullable' => true,
                'default' => null,
                'comment' => 'Page enabled from'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'schedule_to',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                'unsigned' => true,
                'nullable' => true,
                'default' => null,
                'comment' => 'Page enabled up until'
            ]
        );

        $setup->endSetup();
    }
}
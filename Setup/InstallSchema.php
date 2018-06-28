<?php

namespace CatalinMoiceanu\ScheduledPages\Setup;

use CatalinMoiceanu\ScheduledPages\Helper\Page;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            Page::KEY_SCHEDULE_FROM,
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                'unsigned' => true,
                'nullable' => true,
                'default'  => null,
                'comment'  => 'Page enabled from',
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            Page::KEY_SCHEDULE_TO,
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                'unsigned' => true,
                'nullable' => true,
                'default'  => null,
                'comment'  => 'Page enabled up until',
            ]
        );

        $setup->endSetup();
    }
}

<?php

namespace Companyinfo\Review\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
* install tables
*
* @param SchemaSetupInterface $setup
* @param ModuleContextInterface $context
* @return void
* @SuppressWarnings(PHPMD.ExcessiveMethodLength)
*/
class InstallSchema implements InstallSchemaInterface
{
	
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();

		if(!$installer->tableExists('reviews_store_table')) {
			$table = $installer->getConnection()->newTable($installer->getTable('reviews_store_table'))
			->addColumn(
				'id',
				Table::TYPE_INTEGER,
				null,
				[
					'identity' => true,
					'unsigned' => true,
					'nullable' => false,
					'primary' => true
				],
				'Review ID'
			)
			->addColumn(
				'customer_id',
				Table::TYPE_INTEGER,
				10,
				[
					'unsigned' => true,
					'nullable' => false
				],
				'Customer ID'
			)
			->addColumn(
				'review',
				Table::TYPE_TEXT,
				255,
				['nullable' => false],
				'Review'
			)
			->addColumn(
				'create_at',
				Table::TYPE_TIMESTAMP,
				null,
				[
					'nullable' => false,
					'default' => Table::TIMESTAMP_INIT
				],
				'Create at'
			)
			->addColumn(
				'update_at',
				Table::TYPE_TIMESTAMP,
				null,
				['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
				'Update at'
			)
			->addIndex(
				$installer->getIdxName('customer_entity', ['entity_id'], AdapterInterface::INDEX_TYPE_UNIQUE),
    			['customer_id'],
    			AdapterInterface::INDEX_TYPE_UNIQUE
			)
			->addForeignKey(
				$installer->getFkName('reviews_store_table', 'customer_id', 'customer_entity', 'entity_id'),
				'customer_id',
				$installer->getTable('customer_entity'),
				'entity_id',
				Table::ACTION_CASCADE
			)
			->setComment('Reivew Table')
			->setOption('type', 'InnoDB')
            ->setOption('charset', 'utf8')
            ->setOption('collate', 'utf8_general_ci');
			$installer->getConnection()->createTable($table);
		}

		$installer->endSetup();
	}
}
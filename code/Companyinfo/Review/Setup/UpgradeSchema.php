<?php

namespace Companyinfo\Review\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface	$context)
	{
		$setup->startSetup();

		if(version_compare($context->getVersion(), '1.0.2', '<')) {
			$setup->getConnection()->addColumn(
				$setup->getTable('reviews_store_table'),
				'status',
				[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					'nullable' => false,
					'default' => 0,
					'comment' => 'Status'
				]
			);
		}

		$setup->endSetup();

	}
}
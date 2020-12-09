<?php

namespace Companyinfo\Review\Setup;

use	Magento\Framework\Setup\UpgradeDataInterface;
use	Magento\Framework\Setup\ModuleContextInterface;
use	Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
	 /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
	protected $resourceConfig;

	 /**
     * @param \Magento\Config\Model\ResourceModel\Config $resourceConfig
     */
	public function	__construct(\Magento\Config\Model\ResourceModel\Config	$resourceConfig)	
	{
		$this->resourceConfig = $resourceConfig;
	}

	public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface	$context)
	{
		
	}
}
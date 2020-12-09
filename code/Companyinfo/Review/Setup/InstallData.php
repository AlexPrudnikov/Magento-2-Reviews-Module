<?php
namespace Companyinfo\Review\Setup;

use	Magento\Framework\Setup\InstallDataInterface;
use	Magento\Framework\Setup\ModuleContextInterface;
use	Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
	 /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
	protected $resourceConfig;

	 /**
     * @param \Magento\Config\Model\ResourceModel\Config $resourceConfig
     */
	public function __construct(\Magento\Config\Model\ResourceModel\Config $resourceConfig)	
	{
		$this->resourceConfig =	$resourceConfig;
	}
		
	public function	install(ModuleDataSetupInterface $setup, ModuleContextInterface	$context)
	{
		$setup->startSetup();
		
		$this->resourceConfig->saveConfig(
			'catalog/seo/category_canonical_tag',
			true,
			\Magento\Config\Block\System\Config\Form::SCOPE_DEFAULT,
			0
			);

		$setup->endSetup();
	}
}
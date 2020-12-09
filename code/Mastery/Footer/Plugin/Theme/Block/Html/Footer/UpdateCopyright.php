<?php
namespace Mastery\Footer\Plugin\Theme\Block\Html\Footer;

use Magento\Theme\Block\Html\Footer;

class UpdateCopyright extends \Magento\Theme\Block\Html\Footer
{
    /**
     * @param Footer $subject
     * @param string $result
     * @return string $result
     */
    public function aftergetCopyright(Footer $subject, $result)
    {
        $result = '© ' . date('Y') . ' Margo. All rights reserved.';
        return $result;
    }
}
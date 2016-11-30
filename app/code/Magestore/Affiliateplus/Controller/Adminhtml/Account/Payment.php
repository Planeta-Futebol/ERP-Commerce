<?php

/**
 * Magestore.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_Affiliateplus
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */
namespace Magestore\Affiliateplus\Controller\Adminhtml\Account;

use Magento\Framework\Controller\ResultFactory;

/**
 * Action Save
 */
class Payment extends \Magestore\Affiliateplus\Controller\Adminhtml\Affiliateplus
{
    /**
     * Execute action
     */
    public function execute()
    {
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);

        return $resultLayout;
    }
}


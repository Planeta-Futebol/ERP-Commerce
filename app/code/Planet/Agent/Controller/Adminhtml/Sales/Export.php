<?php

namespace Planet\Agent\Controller\Adminhtml\Sales;

use Magento\Backend\App\Action;

class Export extends Action
{
  /**
  * Index Action*
  * @return void
  */
  public function execute()
  {
      $this->_view->loadLayout();
      $this->_view->renderLayout();
  }
}

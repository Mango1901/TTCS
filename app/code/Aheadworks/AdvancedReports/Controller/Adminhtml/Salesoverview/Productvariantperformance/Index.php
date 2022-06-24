<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/


namespace Aheadworks\AdvancedReports\Controller\Adminhtml\Salesoverview\Productvariantperformance;

class Index extends \Aheadworks\AdvancedReports\Controller\Adminhtml\Salesoverview\Productvariantperformance
{
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $productId = $this->_request->getParam('product_id', null);
        if (null === $productId) {
            $redirectResult = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            return $redirectResult->setUrl($this->_redirect->getRefererUrl());
        }
        $resultPage = $this->_initAction();
        return $resultPage;
    }
}

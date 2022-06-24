<?php
/**
 * Created by PhpStorm.
 * User: hiennq
 * Date: 9/12/16
 * Time: 11:13
 */

namespace Magenest\MapList\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;

/**
 * Class Holiday
 * @package Magenest\MapList\Controller\Adminhtml
 */
abstract class Brand extends Action
{
    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magenest\MapList\Model\HolidayFactory
     */
    protected $brandFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Location constructor.
     * @param Action\Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param \Magenest\MapList\Model\BrandFactory $brandFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Action\Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        \Magenest\MapList\Model\BrandFactory $brandFactory,
        LoggerInterface $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->brandFactory = $brandFactory;
        $this->logger = $logger;
        parent::__construct($context); // TODO: Change the autogenerated stub
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Brand Management'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
   {
        return $this->_authorization->isAllowed('Magenest_MapList::list_brand');
   }
}

<?php


namespace Magenest\Affiliate\Controller\Adminhtml\Account;

use Exception;
use Magenest\Affiliate\Controller\Adminhtml\Account;

/**
 * Class Delete
 * @package Magenest\Affiliate\Controller\Adminhtml\Account
 */
class Delete extends Account
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                /** @var \Magenest\Affiliate\Model\Account $account */
                $account = $this->_accountFactory->create();
                $account->load($id);
                $customer_id = $account->getCustomerId();
                $account->delete();
                $this->messageManager->addSuccess(__('The Account has been deleted.'));
                $this->_eventManager->dispatch('affiliate_account_delete_success', ['customer_id' => $customer_id]);

                $resultRedirect->setPath('affiliate/*/');

                return $resultRedirect;
            } catch (Exception $e) {
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                $resultRedirect->setPath('affiliate/*/edit', ['id' => $id]);

                return $resultRedirect;
            }
        }
        $this->messageManager->addError(__('Account to delete was not found.'));
        $resultRedirect->setPath('affiliate/*/');

        return $resultRedirect;
    }
}

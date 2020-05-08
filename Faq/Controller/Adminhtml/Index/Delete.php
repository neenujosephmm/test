<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */
namespace Ceymox\Faq\Controller\Adminhtml\Index;

class Delete extends \Ceymox\Faq\Controller\Adminhtml\Index
{
    /**
     * @var \Ceymox\Faq\Api\FaqRepositoryInterface
     */
    private $faqRepository;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Ceymox\Faq\Api\FaqRepositoryInterface $faqRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Ceymox\Faq\Api\FaqRepositoryInterface $faqRepository
    ) {
            $this->faqRepository = $faqRepository;
            parent::__construct($context, $registry);
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $faq_id = $this->getRequest()->getParam('faq_id');
        if ($faq_id) {
            try {
                $this->faqRepository->deleteById($faq_id);
                $this->messageManager->addSuccess(__('You deleted the item.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['faq_id' => $faq_id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find the item to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}

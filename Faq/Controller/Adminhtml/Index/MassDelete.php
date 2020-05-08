<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */
namespace Ceymox\Faq\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Ceymox\Faq\Model\ResourceModel\Faq\CollectionFactory;
use Ceymox\Faq\Api\FaqRepositoryInterface;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    private $filter;

    /**
     * @var faqRepository
     */
    public $faqRepository;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     * @param FaqRepositoryInterface $faqRepository
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        Filter $filter,
        FaqRepositoryInterface $faqRepository
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
        $this->faqRepository = $faqRepository;
    }

    /**
     * Run mass action
     *
     * @return $this
     */
    public function execute()
    {
        try {
            $faqcollection = $this->collectionFactory->create();
            $collection = $this->filter->getCollection($faqcollection);
            $this->massAction($collection);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');
        return $resultRedirect;
    }

    /**
     * {@inheritdoc}
     */
    private function massAction($collection)
    {
        $deletedCount = 0;
        foreach ($collection->getItems() as $item) {
            $this->faqRepository->deleteById($item->getId());
            $deletedCount++;
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were deleted', $deletedCount));
    }
}

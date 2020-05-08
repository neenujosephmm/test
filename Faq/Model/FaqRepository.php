<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */
 
namespace Ceymox\Faq\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Ceymox\Faq\Api\Data;

class FaqRepository implements \Ceymox\Faq\Api\FaqRepositoryInterface
{
    /**
     * @var faqFactory
     */
    private $faqFactory;
    /**
     * @var ResourceModel\faq
     */
    private $faqResource;
    /**
     * @var \Ceymox\Faq\Api\Data\FaqInterfaceFactory
     */
    private $faqDataFactory;
    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    private $dataObjectHelper;
    /**
     * @var \Magento\Framework\Api\ExtensibleDataObjectConverter
     */
    private $dataObjectConverter;
    /**
     * @var Data\FaqSearchResultInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    private $dataObjectProcessor;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * FaqRepository constructor.
     * @param FaqFactory $faqFactory
     * @param ResourceModel\faq $faqResource
     * @param \Ceymox\Faq\Api\Data\FaqInterfaceFactory $faqDataFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $dataObjectConverter
      * @param \Magento\Framework\View\\Result\PageFactory $resultPageFactory
     * @param Data\FaqSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        \Ceymox\Faq\Model\FaqFactory $faqFactory,
        \Ceymox\Faq\Model\ResourceModel\Faq $faqResource,
        \Ceymox\Faq\Api\Data\FaqInterfaceFactory $faqDataFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $dataObjectConverter,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
    ) {
        $this->faqFactory          = $faqFactory;
        $this->faqResource         = $faqResource;
        $this->faqDataFactory      = $faqDataFactory;
        $this->dataObjectHelper    = $dataObjectHelper;
        $this->dataObjectConverter = $dataObjectConverter;
        $this->resultPageFactory   = $resultPageFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * @param int $Faq_Id
     * @return \Ceymox\Faq\Api\Data\FaqInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($faqId)
    {
        $faqObj = $this->faqFactory->create();
        $this->faqResource->load($faqObj, $faqId);
        if (!$faqObj->getId()) {
            throw new NoSuchEntityException(__('Item with id "%1" does not exist.', $faqId));
        }
        $data = $this->faqDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $data,
            $faqObj->getData(),
            'Ceymox\Faq\Api\Data\FaqInterface'
        );
        $data->setId($faqObj->getfaqId());
        return $data;
    }

    /**
     * Save question Data
     *
     * @param \Ceymox\Faq\Api\Data\FaqInterface
     * @return \Ceymox\Faq\Api\Data\FaqInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\FaqInterface $question)
    {
        $faqData = $this->dataObjectConverter->toNestedArray(
            $question,
            [],
            'Ceymox\Faq\Api\Data\FaqInterface'
        );
        $faqModel = $this->faqFactory->create(['data'=>$faqData]);
        try {
            $faqModel->setfaqId($question->getId());
            $this->faqResource->save($faqModel);
            if ($question->getId()) {
                $question = $this->getById($question->getId());
            } else {
                $question->setId($faqModel->getId());
            }
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the name: %1', $exception->getMessage()));
        }
    }
    /**
     * Delete the question by question id
     * @param $faqId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($faqId)
    {
        $faqObj = $this->faqFactory->create();
        $this->faqResource->load($faqObj, $faqId);
        $this->faqResource->delete($faqObj);
        if ($faqObj->isDeleted()) {
            return true;
        }
        return false;
    }
     /**
      * Load data collection by given search criteria
      *
      * @param SearchCriteriaInterface $searchCriteria
      * @return \Ceymox\Faq\Api\Data\FaqSearchResultInterface
      */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $collection = $this->faqFactory->create()->getCollection();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                /** if no condition is set then it will take eq condition by default */
                $condition = $filter->getConditionType() ?:'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addFaq(
                    $sortOrders->getField(),
                    ($sortOrders->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $signups = [];
        foreach ($collection as $faqModel) {
            $faqData = $this->faqDataFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $faqData,
                $faqModel->getData(),
                'Ceymox\Faq\Api\Data\FaqInterface'
            );
            $signups[] = $this->dataObjectProcessor->buildOutputDataArray(
                $faqData,
                'Ceymox\Faq\Api\Data\FaqInterface'
            );
        }
        $searchResults->setItems($signups);
        return $searchResults;
    }
    /**
     * @param string $faqId
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByName($question)
    {
        $faqObj = $this->faqFactory->create();
        $this->faqResource->load($faqObj, $question, 'question');
        if (!$faqObj->getId()) {
            return 0;
        }
        return $faqObj->getFaqId();
    }   
}

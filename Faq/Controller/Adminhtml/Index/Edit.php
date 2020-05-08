<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */
namespace Ceymox\Faq\Controller\Adminhtml\Index;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Ceymox\Faq\Api\FaqRepositoryInterface
     */
    private $faqRepository;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    private $faqFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Ceymox\Faq\Api\FaqRepositoryInterface $faqRepository,
        \Ceymox\Faq\Model\FaqFactory $faqFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->faqRepository     = $faqRepository;
        $this->faqFactory        = $faqFactory;
        $this->_coreRegistry     = $registry;
        parent::__construct($context);
    }

/**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
    /**
     * Edit item
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
   
         $id = $this->getRequest()->getParam('faq_id');
        $model = $this->_objectManager->create('Ceymox\Faq\Model\Faq');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This contact no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('faq_form', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Faq') : __('New Faq'),
            $id ? __('Edit Faq') : __('New Faq')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Faq'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Faq'));

        return $resultPage;
    }
}

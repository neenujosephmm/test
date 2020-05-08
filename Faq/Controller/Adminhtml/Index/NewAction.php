<?php
/**
 * @author Sreepriya
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */
namespace Ceymox\Faq\Controller\Adminhtml\Index;

class NewAction extends \Ceymox\Faq\Controller\Adminhtml\Index
{
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    private $resultForwardFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Create new item
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}

<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */

namespace Ceymox\Faq\Controller\Adminhtml;

abstract class Index extends \Magento\Backend\App\Action
{
    /**
     * Registry key where current label ID is stored
     */
    const CURRENT_ID      = 'current_id';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry = null;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry)
    {
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Ceymox_Faq::faq')
            ->addBreadcrumb(__('Faq'), __('Faq'))
            ->addBreadcrumb(__('Faq Information'), __(''));
        return $resultPage;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ceymox_faq::faq');
    }

    /**
     * Question initialization
     *
     * @return string faq id
     */
    public function initCurrentItem()
    {
        $faqId = (int)$this->getRequest()->getParam('faq_id');
          
        if ($faqId) {
            $this->coreRegistry->register(self::CURRENT_ID, $faqId);
        }

        return $faqId;
    }
}

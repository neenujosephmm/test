<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */
namespace Ceymox\Faq\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    private $resultPageFactory;
 
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Faq'));
        return $resultPage;
    }
}

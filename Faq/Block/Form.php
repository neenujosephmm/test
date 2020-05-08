<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */
 
namespace Ceymox\Faq\Block;
 
use \Magento\Framework\View\Element\Template;

class Form extends Template
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    private   $formKey;
    protected $_registry;

    /**
     * Form constructor.
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Ceymox\Faq\Model\FaqFactory $modelFactory,
        \Magento\Framework\App\ResourceConnection $Resource,
        \Magento\Framework\Registry $registry,

        array $data = []
    ) {
        $this->_registry    = $registry;
        $this->formKey      = $formKey;
        $this->modelFactory = $modelFactory;
        $this->_resource    = $Resource;
        parent::__construct($context, $data);
    }

     /**
     * get form key
     *
     * @return string
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    public function getFaqCollection()
    {
        $product_id        =$this->_registry->registry('current_product')->getId();
        $modelFactory      = $this->modelFactory->create();
        $collection        = $modelFactory->getCollection()->addFieldToFilter('status','active');
        $second_table_name = $this->_resource->getTableName('ceymox_faqproduct'); 
        $collection->getSelect()->joinLeft(array('second' => $second_table_name),
                                               'main_table.faq_id = second.faq_id');
        $collection->addFieldToFilter('product_id',$product_id);
        return $collection;
       
    }
}

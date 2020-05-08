<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */
namespace Ceymox\Faq\Block\Adminhtml\Faq\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $store;

    /**
    * @var \Ceymox\Faq\Helper\Data $helper
    */
    protected $helper;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Ceymox\Faq\Helper\Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Ceymox\Faq\Model\Faq */
        $model = $this->_coreRegistry->registry('faq_form');

        /** @var \Magento\Framework\Data\Form $form */
        $form  = $this->_formFactory->create();

        $form->setHtmlIdPrefix('faq_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Faq Information')]);

        if ($model->getId()) {
            $fieldset->addField('faq_id', 'hidden', ['name' => 'faq_id']);
        }

        $fieldset->addField(
            'question',
            'text',
            [
                'name'     => 'question',
                'label'    => __('Question'),
                'title'    => __('Question'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'answer',
            'textarea',
            [
                'name'    => 'answer',
                'label'   => __('Answer'),
                'title'   => __('Answer'),
                'required'=> true,
            ]
        );

        $fieldset->addField(
                'status', 'select', array(
                    'label'              => 'Status',
                    'name'               => 'status',
                    'class'              => '',
                    'note'               => '',
                    'style'              => '',
                    'values'=> array('Active'=>'Active', 'In Active'=>'In Active')
                )
            );


        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('FAQ');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('FAQ');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}

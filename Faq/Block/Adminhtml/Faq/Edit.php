<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */

namespace Ceymox\Faq\Block\Adminhtml\Faq;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId   = 'faq_id';
        $this->_blockGroup = 'Ceymox_Faq';
        $this->_controller = 'adminhtml_faq';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save Faq'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ],
            -100
        );

        $this->buttonList->update('delete', 'label', __('Delete Faq'));
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

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('faq/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}

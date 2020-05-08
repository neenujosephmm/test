<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */

namespace Ceymox\Faq\Model\ResourceModel;

class Faq extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const TBL_ATT_PRODUCT = 'ceymox_faqproduct';
    
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;
    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
    }


    /**
     * Initialize resource model
     *
     * @return void
     */
   public function _construct()
    {
        $this->_init('ceymox_faq', 'faq_id');
    }
    /**
     * Process post data before saving
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->isObjectNew() && !$object->hasCreationTime()) {
            $object->setCreationTime($this->_date->gmtDate());
        }

        $object->setUpdateTime($this->_date->gmtDate());

        return parent::_beforeSave($object);
    }
}

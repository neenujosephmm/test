<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */

namespace Ceymox\Faq\Model;

use Magento\Framework\DataObject\IdentityInterface;

class Faq extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{

    /**
     * CMS page cache tag
     */
    const CACHE_TAG        = 'faq_products_grid';

    /**
     * @var string
     */
    protected $_cacheTag   = 'faq_products_grid';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'faq_products_grid';

    /**
     * Initialize resource model
     *
     * @return void
    */
    public function _construct()
    {
        $this->_init('Ceymox\Faq\Model\ResourceModel\Faq');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getProducts(\Ceymox\Faq\Model\Faq $object)
    {
        $tbl = $this->getResource()->getTable(\Ceymox\Faq\Model\ResourceModel\Faq::TBL_ATT_PRODUCT);
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['product_id']
        )
        ->where(
            'faq_id = ?',
            (int)$object->getId()
        );
        return $this->getResource()->getConnection()->fetchCol($select);
    }
}
 
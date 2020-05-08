<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */

namespace Ceymox\Faq\Api\Data;

interface FaqSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Question list.
     *
     * @return \Ceymox\Faq\Api\Data\FaqInterface[]
     */
    public function getItems();

    /**
     * Set Question list.
     *
     * @param \Ceymox\Faq\Api\Data\FaqInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

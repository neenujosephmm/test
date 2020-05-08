<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */

namespace Ceymox\Faq\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Ceymox\Faq\Api\Data\FaqInterface;

interface FaqRepositoryInterface
{

    /**
     * @param int $faq_id
     * @return \Ceymox\Faq\Api\Data\FaqInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($faq_id);

    /**
     * Save label Data
     *
     * @param \Ceymox\Faq\Api\Data\FaqInterface
     * @return \Ceymox\Faq\Api\Data\FaqInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(FaqInterface $question);
    /**
     * Delete the question by faq id
     * @param $faq_id
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */

    public function getList(SearchCriteriaInterface $searchCriteria);
    
}

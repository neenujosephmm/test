<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */

namespace Ceymox\Faq\Model\Data;

use Ceymox\Faq\Api\Data\FaqInterface;

class Faq extends \Magento\Framework\Api\AbstractExtensibleObject implements FaqInterface
{
    /**
     * Get  Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_get(self::FAQ_ID);
    }
    /**
     * Get Question
     *
     * @return string|null
     */
    public function getQuestion()
    {
        return $this->_get(self::QUESTION);
    }

    /**
     * Get  Answer
     *
     * @return string|null
     */
    public function getAnswer()
    {
        return $this->_get(self::ANSWER);
    }

    /**
     * Get  Status
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    /**
     * Set FAQ ID
     *
     * @param int $faq_id
     * @return $this
     */
    public function setId($faq_id)
    {
        return $this->setData(self::FAQ_ID, $faq_id);
    }
    
    /**
     * Set Question
     *
     * @param string $question
     * @return $this
     */
    public function setQuestion($question)
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * Set Answer
     *
     * @param string $answer
     * @return $this
     */
    public function setAnswer($answer)
    {
        return $this->setData(self::ANSWER, $answer);
    }
    /**
     * Set Status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    } 
}

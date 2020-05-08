<?php
/**
 * @author Ceymox Team
 * @copyright Copyright (c) 2019 Ceymox (https://ceymox.com)
 * @package Ceymox_Faq
 */

namespace Ceymox\Faq\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
 
interface FaqInterface extends ExtensibleDataInterface
{
    const FAQ_ID                      = 'faq_id';
    const QUESTION                    = 'question';
    const ANSWER                      = 'answer';
    const STATUS                      = 'status';


    /**
     * @return int
     */
    public function getId();
 
    /**
     * Get Question
     *
     * @return string|null
     */
    public function getQuestion();
   
    /**
     * Get Answer
     *
     * @return string|null
     */
    public function getAnswer();

    /**
     * Get Status
     *
     * @return string|null
     */
    public function getStatus();
    

    /**
     * @param int $faq_id
     * @return FaqInterface
     */
    public function setId($faq_id);

    /**
     * @param $question
     * @return FaqInterface
     */
    public function setQuestion($question);

    /**
     * @param $answer
     * @return FaqInterface
     */
    public function setAnswer($answer);

    /**
     * @param  $status
     * @return FaqInterface
     */
    public function setStatus($status);

}

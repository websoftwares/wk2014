<?php
namespace Websoftwares\Wk2014;
use Psr\Log\LoggerInterface;
/**
* Base class
*
* @package Websoftwares
* @subpackage Wk2014
* @license http://opensource.org/licenses/MIT
* @author Boris <boris@websoftwar.es>
*/
class Base
{
    /**
     * $language
     * @var string
     */
    public $language = "EN";

    /**
     * $logger instance of LoggerInterface
     * @var object
     */
    public $logger = null;

    /**
     * __construct
     * @param LoggerInterface $logger object that is an instance of LoggerInterface
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * getTranslation
     * @param  string $language
     * @param  string $column
     * @return array
     */
    public function getTranslation($language = null, $column = null)
    {
        $languageClass = '\\Websoftwares\\Wk2014\\Language\\' . strtoupper($language);
        if (class_exists($languageClass)) {
            $translation = (new $languageClass)->getTranslations();
            return array_key_exists($column, $translation) ? $translation[$column] : [] ;
        } else {
            return [];
        }
    }
}

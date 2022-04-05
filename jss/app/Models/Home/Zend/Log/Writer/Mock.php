<?php
/**
 * Zend Framework.
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 * @version    $Id: Mock.php 24593 2012-01-05 20:35:02Z matthew $
 */

/** Zend_Log_Writer_Abstract */
require_once 'Zend/Log/Writer/Abstract.php';

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 * @version    $Id: Mock.php 24593 2012-01-05 20:35:02Z matthew $
 */
class Zend_Log_Writer_Mock extends Zend_Log_Writer_Abstract
{
    /**
     * array of log events.
     *
     * @var array
     */
    public $events = [];

    /**
     * shutdown called?
     *
     * @var bool
     */
    public $shutdown = false;

    /**
     * Write a message to the log.
     *
     * @param  array  $event  event data
     */
    public function _write($event): void
    {
        $this->events[] = $event;
    }

    /**
     * Record shutdown.
     */
    public function shutdown(): void
    {
        $this->shutdown = true;
    }

    /**
     * Create a new instance of Zend_Log_Writer_Mock.
     *
     * @param  array|Zend_Config $config
     *
     * @return Zend_Log_Writer_Mock
     */
    public static function factory($config)
    {
        return new self();
    }
}

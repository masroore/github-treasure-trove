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
 * @version    $Id: Null.php 24593 2012-01-05 20:35:02Z matthew $
 */

/** Zend_Log_Writer_Abstract */
require_once 'Zend/Log/Writer/Abstract.php';

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 * @version    $Id: Null.php 24593 2012-01-05 20:35:02Z matthew $
 */
class Zend_Log_Writer_Null extends Zend_Log_Writer_Abstract
{
    /**
     * Write a message to the log.
     *
     * @param  array  $event  event data
     */
    protected function _write($event): void
    {
    }

    /**
     * Create a new instance of Zend_Log_Writer_Null.
     *
     * @param  array|Zend_Config $config
     *
     * @return Zend_Log_Writer_Null
     */
    public static function factory($config)
    {
        return new self();
    }
}

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
 * @version    $Id: Firebug.php 24593 2012-01-05 20:35:02Z matthew $
 */

/** Zend_Log_Formatter_Abstract */
require_once 'Zend/Log/Formatter/Abstract.php';

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Log_Formatter_Firebug extends Zend_Log_Formatter_Abstract
{
    /**
     * Factory for Zend_Log_Formatter_Firebug classe.
     *
     * @param array|Zend_Config $options useless
     *
     * @return Zend_Log_Formatter_Firebug
     */
    public static function factory($options)
    {
        return new self();
    }

    /**
     * This method formats the event for the firebug writer.
     *
     * The default is to just send the message parameter, but through
     * extension of this class and calling the
     * {@see Zend_Log_Writer_Firebug::setFormatter()} method you can
     * pass as much of the event data as you are interested in.
     *
     * @param  array    $event    event data
     *
     * @return mixed              event message
     */
    public function format($event)
    {
        return $event['message'];
    }
}

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
 * @version    $Id: Abstract.php 24593 2012-01-05 20:35:02Z matthew $
 */

/** @see Zend_Log_Formatter_Interface */
require_once 'Zend/Log/Formatter/Interface.php';

/** @see Zend_Log_FactoryInterface */
require_once 'Zend/Log/FactoryInterface.php';

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 * @version    $Id: Abstract.php 24593 2012-01-05 20:35:02Z matthew $
 */
abstract class Zend_Log_Formatter_Abstract implements Zend_Log_FactoryInterface, Zend_Log_Formatter_Interface
{
}

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

/** @see Zend_Log_Filter_Interface */
require_once 'Zend/Log/Filter/Interface.php';

/** @see Zend_Log_FactoryInterface */
require_once 'Zend/Log/FactoryInterface.php';

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 * @version    $Id: Abstract.php 24593 2012-01-05 20:35:02Z matthew $
 */
abstract class Zend_Log_Filter_Abstract implements Zend_Log_FactoryInterface, Zend_Log_Filter_Interface
{
    /**
     * Validate and optionally convert the config to array.
     *
     * @param  array|Zend_Config $config Zend_Config or Array
     *
     * @return array
     */
    protected static function _parseConfig($config)
    {
        if ($config instanceof Zend_Config) {
            $config = $config->toArray();
        }

        if (!is_array($config)) {
            require_once 'Zend/Log/Exception.php';

            throw new Zend_Log_Exception('Configuration must be an array or instance of Zend_Config');
        }

        return $config;
    }
}

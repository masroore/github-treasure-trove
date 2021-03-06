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
 * @version    $Id: AdapterAggregate.php 24593 2012-01-05 20:35:02Z matthew $
 */

/**
 * Interface that aggregates a Zend_Paginator_Adapter_Abstract just like IteratorAggregate does for Iterators.
 *
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
interface Zend_Paginator_AdapterAggregate
{
    /**
     * Return a fully configured Paginator Adapter from this method.
     *
     * @return Zend_Paginator_Adapter_Interface
     */
    public function getPaginatorAdapter();
}

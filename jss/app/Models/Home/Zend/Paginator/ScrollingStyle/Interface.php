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
 * @version    $Id: Interface.php 24593 2012-01-05 20:35:02Z matthew $
 */

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
interface Zend_Paginator_ScrollingStyle_Interface
{
    /**
     * Returns an array of "local" pages given a page number and range.
     *
     * @param  int $pageRange (Optional) Page range
     *
     * @return array
     */
    public function getPages(Zend_Paginator $paginator, $pageRange = null);
}
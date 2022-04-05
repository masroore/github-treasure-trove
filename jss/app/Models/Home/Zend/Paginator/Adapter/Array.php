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
 * @version    $Id: Array.php 24593 2012-01-05 20:35:02Z matthew $
 */

/**
 * @see Zend_Paginator_Adapter_Interface
 */
require_once 'Zend/Paginator/Adapter/Interface.php';

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Paginator_Adapter_Array implements Zend_Paginator_Adapter_Interface
{
    /**
     * Array.
     *
     * @var array
     */
    protected $_array;

    /**
     * Item count.
     *
     * @var int
     */
    protected $_count;

    /**
     * Constructor.
     *
     * @param array $array Array to paginate
     */
    public function __construct(array $array)
    {
        $this->_array = $array;
        $this->_count = count($array);
    }

    /**
     * Returns an array of items for a page.
     *
     * @param  int $offset Page offset
     * @param  int $itemCountPerPage Number of items per page
     *
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return array_slice($this->_array, $offset, $itemCountPerPage);
    }

    /**
     * Returns the total number of rows in the array.
     *
     * @return int
     */
    public function count()
    {
        return $this->_count;
    }
}

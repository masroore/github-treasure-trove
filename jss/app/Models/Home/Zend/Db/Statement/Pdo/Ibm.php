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
 * @version    $Id: Ibm.php 24593 2012-01-05 20:35:02Z matthew $
 */

/**
 * @see Zend_Db_Statement_Pdo
 */
require_once 'Zend/Db/Statement/Pdo.php';

/**
 * Proxy class to wrap a PDOStatement object for IBM Databases.
 * Matches the interface of PDOStatement.  All methods simply proxy to the
 * matching method in PDOStatement.  PDOExceptions thrown by PDOStatement
 * are re-thrown as Zend_Db_Statement_Exception.
 *
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Db_Statement_Pdo_Ibm extends Zend_Db_Statement_Pdo
{
    /**
     * Returns an array containing all of the result set rows.
     *
     * Behaves like parent, but if limit()
     * is used, the final result removes the extra column
     * 'zend_db_rownum'
     *
     * @param int $style OPTIONAL Fetch mode
     * @param int $col   OPTIONAL Column number, if fetch mode is by column
     *
     * @return array collection of rows, each in a format by the fetch mode
     */
    public function fetchAll($style = null, $col = null)
    {
        $data = parent::fetchAll($style, $col);
        $results = [];
        $remove = $this->_adapter->foldCase('ZEND_DB_ROWNUM');

        foreach ($data as $row) {
            if (is_array($row) && array_key_exists($remove, $row)) {
                unset($row[$remove]);
            }
            $results[] = $row;
        }

        return $results;
    }

    /**
     * Binds a parameter to the specified variable name.
     *
     * @param mixed $parameter name the parameter, either integer or string
     * @param mixed $variable  reference to PHP variable containing the value
     * @param mixed $type      OPTIONAL Datatype of SQL parameter
     * @param mixed $length    OPTIONAL Length of SQL parameter
     * @param mixed $options   OPTIONAL Other options
     *
     * @return bool
     */
    public function _bindParam($parameter, &$variable, $type = null, $length = null, $options = null)
    {
        try {
            if (($type === null) && ($length === null) && ($options === null)) {
                return $this->_stmt->bindParam($parameter, $variable);
            }

            return $this->_stmt->bindParam($parameter, $variable, $type, $length, $options);
        } catch (PDOException $e) {
            require_once 'Zend/Db/Statement/Exception.php';

            throw new Zend_Db_Statement_Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
}

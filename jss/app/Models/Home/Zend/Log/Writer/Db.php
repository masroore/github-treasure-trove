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
 * @version    $Id: Db.php 25247 2013-02-01 17:49:40Z frosch $
 */

/** Zend_Log_Writer_Abstract */
require_once 'Zend/Log/Writer/Abstract.php';

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 * @version    $Id: Db.php 25247 2013-02-01 17:49:40Z frosch $
 */
class Zend_Log_Writer_Db extends Zend_Log_Writer_Abstract
{
    /**
     * Database adapter instance.
     *
     * @var Zend_Db_Adapter
     */
    protected $_db;

    /**
     * Name of the log table in the database.
     *
     * @var string
     */
    protected $_table;

    /**
     * Relates database columns names to log data field keys.
     *
     * @var null|array
     */
    protected $_columnMap;

    /**
     * Class constructor.
     *
     * @param Zend_Db_Adapter $db   Database adapter instance
     * @param string $table         Log table in database
     * @param array $columnMap
     */
    public function __construct($db, $table, $columnMap = null)
    {
        $this->_db = $db;
        $this->_table = $table;
        $this->_columnMap = $columnMap;
    }

    /**
     * Create a new instance of Zend_Log_Writer_Db.
     *
     * @param  array|Zend_Config $config
     *
     * @return Zend_Log_Writer_Db
     */
    public static function factory($config)
    {
        $config = self::_parseConfig($config);
        $config = array_merge([
            'db' => null,
            'table' => null,
            'columnMap' => null,
        ], $config);

        if (isset($config['columnmap'])) {
            $config['columnMap'] = $config['columnmap'];
        }

        return new self(
            $config['db'],
            $config['table'],
            $config['columnMap']
        );
    }

    /**
     * Formatting is not possible on this writer.
     */
    public function setFormatter(Zend_Log_Formatter_Interface $formatter): void
    {
        require_once 'Zend/Log/Exception.php';

        throw new Zend_Log_Exception(static::class . ' does not support formatting');
    }

    /**
     * Remove reference to database adapter.
     */
    public function shutdown(): void
    {
        $this->_db = null;
    }

    /**
     * Write a message to the log.
     *
     * @param  array  $event  event data
     */
    protected function _write($event): void
    {
        if ($this->_db === null) {
            require_once 'Zend/Log/Exception.php';

            throw new Zend_Log_Exception('Database adapter is null');
        }

        if ($this->_columnMap === null) {
            $dataToInsert = $event;
        } else {
            $dataToInsert = [];
            foreach ($this->_columnMap as $columnName => $fieldKey) {
                if (isset($event[$fieldKey])) {
                    $dataToInsert[$columnName] = $event[$fieldKey];
                }
            }
        }

        $this->_db->insert($this->_table, $dataToInsert);
    }
}

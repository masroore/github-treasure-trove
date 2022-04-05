<?php
/**
 * @see ArraySorter
 */
require_once 'arraysorter.class.php';

/**
 * App Model.
 *
 * This class includes common function as Entity-model
 *
 * @author K3
 *
 * @since 2012/03/12
 */
class Model_Appmodel
{
    const LOG_INSERT = 1;
    const LOG_UPDATE = 2;
    const LOG_DELETE = 3;

    const LOG_TABLE_SUFFIX = '_log';

    /**
     * MySQL Db Adapter object.
     *
     * @var MysqlDB
     */
    protected static $_dbAdapter;

    /**
     * The table name.
     *
     * @var string
     */
    protected $_name;

    /**
     * The schema name (default null means current schema).
     *
     * @var array
     */
    protected $_schema;

    /**
     * The table column names derived from Zend_Db_Adapter_Abstract::describeTable().
     *
     * @var array
     */
    protected $_cols;

    /**
     * The primary key column or columns.
     * A compound key should be declared as an array.
     * You may declare a single-column primary key
     * as a string.
     *
     * @var mixed
     */
    protected $_primary;

    /**
     * Information provided by the adapter's describeTable() method.
     *
     * @var array
     */
    protected $_metadata = [];

    /**
     * Constructor : メンバーの初期化.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        // Db adapter
        global $g_dbAdapter;
        if (empty(self::$_dbAdapter)) {
            self::$_dbAdapter = $g_dbAdapter;
        }

        // check config
        foreach ($config as $key => $value) {
            switch ($key) {
                case 'name':
                    $this->_name = $value;

                    break;
            }
        }

        //parent::__construct($config);
        $this->_getCols();
        $this->_setupPrimaryKey();
    }

    /**
     * Retrieve table columns.
     *
     * @return array
     */
    protected function _getCols()
    {
        if (null === $this->_cols) {
            $this->_setupMetadata();
            $this->_cols = array_keys($this->_metadata);
        }

        return $this->_cols;
    }

    /**
     * Initialize primary key from metadata.
     * If $_primary is not defined, discover primary keys
     * from the information returned by describeTable().
     */
    protected function _setupPrimaryKey(): void
    {
        if (!$this->_primary) {
            $this->_setupMetadata();
            $this->_primary = [];
            foreach ($this->_metadata as $col) {
                if ($col['PRIMARY']) {
                    $this->_primary[$col['PRIMARY_POSITION']] = $col['COLUMN_NAME'];
                    if ($col['IDENTITY']) {
                        $this->_identity = $col['PRIMARY_POSITION'];
                    }
                }
            }
            // if no primary key was specified and none was found in the metadata
            // then throw an exception.
            if (empty($this->_primary)) {
                //require_once 'Zend/Db/Table/Exception.php';
                //throw new Zend_Db_Table_Exception('A table must have a primary key, but none was found');
                exit('A table must have a primary key, but none was found');
            }
        } elseif (!is_array($this->_primary)) {
            $this->_primary = [1 => $this->_primary];
        } elseif (isset($this->_primary[0])) {
            array_unshift($this->_primary, null);
            unset($this->_primary[0]);
        }

        $cols = $this->_getCols();
        if (!array_intersect((array) $this->_primary, $cols) == (array) $this->_primary) {
            //require_once 'Zend/Db/Table/Exception.php';
            //throw new Zend_Db_Table_Exception
            throw new Exception('Primary key column(s) ('
            . implode(',', (array) $this->_primary)
            . ') are not columns in this table ('
            . implode(',', $cols)
            . ')');
        }

        $primary = (array) $this->_primary;
    }

    /**
     * Initializes metadata.
     *
     * If metadata cannot be loaded from cache, adapter's describeTable() method is called to discover metadata
     * information. Returns true if and only if the metadata are loaded from cache.
     *
     * @return bool
     */
    protected function _setupMetadata()
    {
        if (count($this->_metadata) > 0) {
            return true;
        }

        $metadata = self::$_dbAdapter->describeTable($this->_name, $this->_schema);

        // Assign the metadata to $this
        $this->_metadata = $metadata;

        // Return whether the metadata were loaded from cache
        return true;
    }

    /**
     * Sets the default DB Adapter for all Model objects.
     *
     * @param  MysqlDB $db DB Adapter
     */
    public static function setAdapter($db = null): void
    {
        if (!$db instanceof MysqlDB) {
            throw new Exception('DB Adpater must be MysqlDB object.');
        }

        self::$_dbAdapter = $db;
    }

    /**
     * Gets the default DB Adapter for all Model objects.
     *
     * @return MysqlDB or null
     */
    public static function getAdapter()
    {
        return self::$_dbAdapter;
    }

    /**
     * Limit文を構成する。
     *
     * @param int $offset
     * @param int $limit
     *
     * @return string
     */
    protected function _composeLimit($offset, $limit)
    {
        if (empty($offset) && empty($limit)) {
            return '';
        } elseif (empty($offset) && $limit + 0 > 0) {
            return " LIMIT 0, $limit";
        } elseif (empty($limit)) {
            return " LIMIT $offset";
        }

        $offset = (int) $offset;
        $limit = (int) $limit;

        return " LIMIT $offset, $limit";
    }

    /**
     * Order By文を構成する。
     *
     * @param int $sortKey
     * @param int $sortOrder
     *
     * @return string
     */
    protected function _composeOrderBy($sortKey, $sortOrder)
    {
        if (empty($sortKey)) {
            return '';
        } elseif (empty($sortOrder)) {
            return " ORDER BY $sortKey ASC";
        }

        return " ORDER BY $sortKey $sortOrder";
    }

    /**
     * ログテーブルにレコード操作履歴を残す。
     *
     * @param array $record
     * @param int $operType
     *
     * @return int
     */
    protected function _writeDbLog($record, $operType, $operator)
    {
        if (empty($this->_name)) {
            return false;
        }

        // ログテーブルがあるかチェックする。
        $logTblName = $this->_name . self::LOG_TABLE_SUFFIX;
        $tblName = $logTblName;

        // ログテーブルに操作履歴を残す。
        $record['original_id'] = $record['id'];
        unset($record['id']);
        $record['operation'] = $operType + 0;
        $record['operator'] = !empty($operator) ? $operator : 0;
        $record['operation_time'] = date('Y-m-d H:i:s'); // now

        if (empty($this->_logModel)) {
            $this->_logModel = new self(['name' => $tblName]);
        }

        $record = $this->_logModel->extract($record);
        $result = self::$_dbAdapter->insert($tblName, $record);

        return $result;
    }

    /**
     * Insert new row.
     *
     * Ensure that a timestamp is set for the created field.
     *
     * @return int Inserted ID
     */
    public function insert(array $data, $logUserId = 0, $writeLog = true)
    {
        // current timestamp
        $now = date('Y-m-d H:i:s');

        // inserted time, updated time
        $data['created_at'] = $now;
        $data['updated_at'] = $now;

        // extract values from $data, and insert
        $data = $this->extract($data);
        $result = self::$_dbAdapter->insert($this->_name, $data);

        // データベース登録履歴を残す。
        if ($result > 0 && $writeLog) {
            $data['id'] = self::$_dbAdapter->lastInsertId();
            $this->_writeDbLog($data, self::LOG_INSERT, $logUserId);
        }

        return $result;
    }

    /**
     * Override updating.
     *
     * Do not allow updating of entries
     *
     * @param  mixed $where
     * @param  bool $writeLog
     */
    public function update(array $data, $where, $logUserId = 0, $writeLog = true, $isUpdateTime = false)
    {
        // updated timestamp
        if ($isUpdateTime) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        $data = $this->extract($data);

        if ($writeLog) {
            $updatedRecords = $this->getRecordsFromWhere($where);
            if (empty($updatedRecords)) {
                return 0;
            }
        }

        $result = self::$_dbAdapter->update($this->_name, $data, $where);

        if ($writeLog) {
            foreach ($updatedRecords as $idx => $record) {
                $record = array_merge($record, $data);
                $this->_writeDbLog($record, self::LOG_UPDATE, $logUserId);
            }
        }

        return $result;
    }

    /**
     * Delete records.
     *
     * @param  mixed $where
     *
     * @return
     */
    public function delete($where, $loginUserId = 0, $writeLog = true)
    {
        $deletedRecords = $this->getRecordsFromWhere($where);
        if (empty($deletedRecords)) {
            return 0;
        }

        $result = self::$_dbAdapter->delete($this->_name, $where);
        if (empty($result)) {
            return 0;
        }

        if ($writeLog) {
            foreach ($deletedRecords as $idx => $record) {
                $this->_writeDbLog($record, self::LOG_DELETE, $loginUserId);
            }
        }

        return $result;
    }

    /**
     * Get record by ID.
     *
     * @param number $id
     *
     * @return mixed
     */
    public function getRecordFromID($id, $lockStr = '')
    {
        if (!is_numeric($id)) {
            return [];
        }

        // Get PRIMARY-field's name
        $primaryKey = empty($this->_primary) ? 'id' : $this->_primary;
        $primaryKey = is_array($primaryKey) ? $primaryKey[1] : (string) $primaryKey;

        // 削除フラグも反映してクエリを生成する。
        $where = '`' . $primaryKey . '`=' . $id;
        if (in_array('del_flag', $this->_cols)) {
            $where .= ' AND `del_flag`=0';
        }

        $query = "SELECT * FROM `{$this->_name}` WHERE {$where} {$lockStr}";
        $result = self::$_dbAdapter->fetchRow($query);

        return $result;
    }

    /**
     * Get record by Where Clause.
     *
     * @param string $where
     *
     * @return mixed
     */
    public function getRecordFromWhere($where, $lockStr = '')
    {
        $where ??= '1=1';
        $query = "SELECT * FROM `{$this->_name}` WHERE {$where} {$lockStr}";
        $result = self::$_dbAdapter->fetchRow($query);

        return $result;
    }

    /**
     * Get record by Where Clause.
     *
     * @param string $where
     *
     * @return mixed
     */
    public function getRecordsFromWhere($where, $lockStr = '')
    {
        $where ??= '1=1';
        $query = "SELECT * FROM `{$this->_name}` WHERE {$where} $lockStr";
        $result = self::$_dbAdapter->fetchAll($query);

        return $result;
    }

    /**
     * Count records matched with condition.
     *
     * @param string $where
     *
     * @return int
     */
    public function count($where = '')
    {
        $query = 'SELECT count(*) FROM `' . $this->_name . '` ' . (empty($where) ? '' : 'WHERE ' . $where);
        $result = self::$_dbAdapter->fetchOne($query);

        return (int) $result;
    }

    /**
     * Extract fields from array data, included fields.
     *
     * in case of $fillEmpty=true, set empty value to undefinded fields' value
     *
     * @param array $record
     * @param bool $fillEmpty
     *
     * @return array
     */
    public function extract($record, $fillEmpty = false)
    {
        $result = [];
        foreach ($this->_cols as $field) {
            if (isset($record[$field])) {
                $result[$field] = $record[$field];
            } elseif ($fillEmpty) {
                $result[$field] = '';
            }
        }

        return $result;
    }

    /**
     * Delete records whose IDs are specified.
     *
     * @param array ids
     *
     * @return int Deleted records' number
     */
    public function deleteByIDs($ids)
    {
        if (empty($ids)) {
            return 0;
        }

        // Get PRIMARY KEY-field's name
        $primaryKey = empty($this->_primary) ? 'id' : $this->_primary;
        $primaryKey = is_array($primaryKey) ? $primaryKey[1] : (string) $primaryKey;

        // 削除処理
        $query = $primaryKey . ' IN (' . implode(',', $ids) . ')';
        $result = $this->delete($query);

        return $result;
    }

    /**
     * Check field value is duplicated or not.
     *
     * @param string $fieldName
     * @param mixed $value
     * @param int $recordID
     * @param string $where
     * @param bool $strict
     *
     * @return array|false （false: not duplicated, array: same-valued records' id）
     */
    public function checkDuplication($fieldName, $value, $recordID = 0, $where = '', $strict = false)
    {
        // Get PRIMARY KEY-field's name
        $primaryKey = empty($this->_primary) ? 'id' : $this->_primary;
        $primaryKey = is_array($primaryKey) ? $primaryKey[1] : (string) $primaryKey;

        // QUERY条件問を構成する。
        $where = empty($where) ? '' : $where . ' AND ';

        if (is_numeric($value)) {
            $where .= $fieldName . '=' . $value;
        } else {
            $where .= $fieldName . '=\'' . $value . '\'';
        }
        if (in_array('del_flag', $this->_cols) && !$strict) {
            $where .= ' AND `del_flag`=0';
        }

        // 現在のレコード以外の場合のみチェックするように。。。
        if ($recordID > 0) {
            $where .= ' AND NOT ' . $primaryKey . '=' . $recordID;
        }

        $sql = "SELECT {$fieldName} FROM {$this->_name} WHERE {$where}";
        $result = self::$_dbAdapter->fetchCol($sql);

        return empty($result) ? false : $result;
    }

    /**
     * ID配列からレコードを情報を取得する。
     *
     * 指定するフィールドを抽出してIDをキーにした
     * レコードとして取り戻す。
     *
     * @param string $addtionalCond
     * @param string $tableName
     *
     * @return array
     */
    public function getRecordsFromIDs(array $ids, array $fields, $addtionalCond = '', $tableName = '')
    {
        if (empty($ids) || empty($fields)) {
            return [];
        }
        $ids = array_unique($ids);
        foreach ($ids as $_key => $_value) {
            if (empty($_value)) {
                $ids[$_key] = 0;
            }
        }
        $fields = array_unique($fields);

        if (count($ids) == 1 && empty($ids[0])) {
            return [];
        }

        // Get PRIMARY KEY-field's name
        $primaryKey = 'id';
        if (empty($tableName)) {
            $primaryKey = empty($this->_primary) ? 'id' : $this->_primary;
            $primaryKey = is_array($primaryKey) ? $primaryKey[1] : (string) $primaryKey;

            $tableName = $this->_name;
        }

        if (!in_array($primaryKey, $fields)) {
            $fields[] = $primaryKey;
        }

        // 削除フラグも反映してクエリを生成する。
        $where = "`$primaryKey` IN(" . implode(',', $ids) . ')';
        //if (in_array('del_flag', $this->_cols))
        //    $where .= ' AND `del_flag`=0';
        if (!empty($addtionalCond)) {
            $where .= ' AND ' . $addtionalCond;
        }

        // 該当するレコードをデータベースから取得する。
        $records = self::$_dbAdapter->fetchRecords($tableName, $fields, $where);

        // レコードをIDをキーとしたものに変換する。
        $results = [];
        foreach ($records as $record) {
            $results[$record[$primaryKey]] = $record;
        }

        return $results;
    }

    /**
     * Get records.
     *
     * @param array|string $fields
     * @param string $where
     * @param string $sortKey
     * @param string $sortOrder
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function fetchRecords($fields, $where = '', $sortKey = '', $sortOrder = 'ASC', $offset = 0, $limit = 0)
    {
        return self::$_dbAdapter->fetchRecords($this->_name, $fields, $where, $sortKey, $sortOrder, $offset, $limit);
    }

    /**
     * Invert status of id-specified records.
     *
     * @param array $ids
     *
     * @return int affected records
     */
    public function exchangeByIDs($ids)
    {
        if (empty($ids)) {
            return 0;
        }

        $query = 'UPDATE `' . $this->_name . '` SET `status`=1-`status` WHERE id IN (' . implode(',', $ids) . ')';
        $result = self::$_dbAdapter->query($query);
        $result = mysql_affected_rows();

        return $result;
    }
}

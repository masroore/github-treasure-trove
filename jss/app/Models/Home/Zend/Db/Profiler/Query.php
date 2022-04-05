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
 * @version    $Id: Query.php 24593 2012-01-05 20:35:02Z matthew $
 */

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Db_Profiler_Query
{
    /**
     * SQL query string or user comment, set by $query argument in constructor.
     *
     * @var string
     */
    protected $_query = '';

    /**
     * One of the Zend_Db_Profiler constants for query type, set by $queryType argument in constructor.
     *
     * @var int
     */
    protected $_queryType = 0;

    /**
     * Unix timestamp with microseconds when instantiated.
     *
     * @var float
     */
    protected $_startedMicrotime;

    /**
     * Unix timestamp with microseconds when self::queryEnd() was called.
     *
     * @var int
     */
    protected $_endedMicrotime;

    /**
     * @var array
     */
    protected $_boundParams = [];

    /**
     * @var array
     */

    /**
     * Class constructor.  A query is about to be started, save the query text ($query) and its
     * type (one of the Zend_Db_Profiler::* constants).
     *
     * @param  string  $query
     * @param  int $queryType
     */
    public function __construct($query, $queryType)
    {
        $this->_query = $query;
        $this->_queryType = $queryType;
        // by default, and for backward-compatibility, start the click ticking
        $this->start();
    }

    /**
     * Clone handler for the query object.
     */
    public function __clone()
    {
        $this->_boundParams = [];
        $this->_endedMicrotime = null;
        $this->start();
    }

    /**
     * Starts the elapsed time click ticking.
     * This can be called subsequent to object creation,
     * to restart the clock.  For instance, this is useful
     * right before executing a prepared query.
     */
    public function start(): void
    {
        $this->_startedMicrotime = microtime(true);
    }

    /**
     * Ends the query and records the time so that the elapsed time can be determined later.
     */
    public function end(): void
    {
        $this->_endedMicrotime = microtime(true);
    }

    /**
     * Returns true if and only if the query has ended.
     *
     * @return bool
     */
    public function hasEnded()
    {
        return $this->_endedMicrotime !== null;
    }

    /**
     * Get the original SQL text of the query.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->_query;
    }

    /**
     * Get the type of this query (one of the Zend_Db_Profiler::* constants).
     *
     * @return int
     */
    public function getQueryType()
    {
        return $this->_queryType;
    }

    /**
     * @param string $param
     * @param mixed $variable
     */
    public function bindParam($param, $variable): void
    {
        $this->_boundParams[$param] = $variable;
    }

    public function bindParams(array $params): void
    {
        if (array_key_exists(0, $params)) {
            array_unshift($params, null);
            unset($params[0]);
        }
        foreach ($params as $param => $value) {
            $this->bindParam($param, $value);
        }
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return $this->_boundParams;
    }

    /**
     * Get the elapsed time (in seconds) that the query ran.
     * If the query has not yet ended, false is returned.
     *
     * @return false|float
     */
    public function getElapsedSecs()
    {
        if (null === $this->_endedMicrotime) {
            return false;
        }

        return $this->_endedMicrotime - $this->_startedMicrotime;
    }

    /**
     * Get the time (in seconds) when the profiler started running.
     *
     * @return bool|float
     */
    public function getStartedMicrotime()
    {
        if (null === $this->_startedMicrotime) {
            return false;
        }

        return $this->_startedMicrotime;
    }
}

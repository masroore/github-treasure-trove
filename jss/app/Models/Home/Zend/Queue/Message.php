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
 * @version    $Id: Message.php 24593 2012-01-05 20:35:02Z matthew $
 */

/**
 * Class for managing queue messages.
 *
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Queue_Message
{
    /**
     * The data for the queue message.
     *
     * @var array
     */
    protected $_data = [];

    /**
     * Connected is true if we have a reference to a live
     * Zend_Queue_Adapter_Abstract object.
     * This is false after the Message has been deserialized.
     *
     * @var bool
     */
    protected $_connected = true;

    /**
     * Zend_Queue parent class or instance.
     *
     * @var Zend_Queue
     */
    protected $_queue;

    /**
     * Name of the class of the Zend_Queue.
     *
     * @var string
     */
    protected $_queueClass;

    /**
     * Constructor.
     */
    public function __construct(array $options = [])
    {
        if (isset($options['queue'])) {
            if ($options['queue'] instanceof Zend_Queue) {
                $this->_queue = $options['queue'];
                $this->_queueClass = get_class($this->_queue);
            } else {
                $result = gettype($options['queue']);
                if ($result === 'object') {
                    $result = get_class($options['queue']);
                }

                require_once 'Zend/Queue/Exception.php';

                throw new Zend_Queue_Exception(
                    '$options[\'queue\'] = '
                    . $result
                    . ': must be instanceof Zend_Queue'
                );
            }
        }
        if (isset($options['data'])) {
            if (!is_array($options['data'])) {
                require_once 'Zend/Queue/Exception.php';

                throw new Zend_Queue_Exception('Data must be an array');
            }
            $this->_data = $options['data'];
        }
    }

    /**
     * Retrieve message field value.
     *
     * @param  string $key the user-specified key name
     *
     * @return string      the corresponding key value
     */
    public function __get($key)
    {
        if (!array_key_exists($key, $this->_data)) {
            require_once 'Zend/Queue/Exception.php';

            throw new Zend_Queue_Exception("Specified field \"$key\" is not in the message");
        }

        return $this->_data[$key];
    }

    /**
     * Set message field value.
     *
     * @param  string $key   the message key
     * @param  mixed  $value the value for the property
     */
    public function __set($key, $value): void
    {
        if (!array_key_exists($key, $this->_data)) {
            require_once 'Zend/Queue/Exception.php';

            throw new Zend_Queue_Exception("Specified field \"$key\" is not in the message");
        }
        $this->_data[$key] = $value;
    }

    /**
     * Test existence of message field.
     *
     * @param  string  $key the column key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return array_key_exists($key, $this->_data);
    }

    // Serialize

    /**
     * Store queue and data in serialized object.
     *
     * @return array
     */
    public function __sleep()
    {
        return ['_queueClass', '_data'];
    }

    /**
     * Setup to do on wakeup.
     * A de-serialized Message should not be assumed to have access to a live
     * queue connection, so set _connected = false.
     */
    public function __wakeup(): void
    {
        $this->_connected = false;
    }

    /**
     * Returns the queue object, or null if this is disconnected message.
     *
     * @return null|Zend_Queue
     */
    public function getQueue()
    {
        return $this->_queue;
    }

    /**
     * Set the queue object, to re-establish a live connection
     * to the queue for a Message that has been de-serialized.
     *
     * @return bool
     */
    public function setQueue(Zend_Queue $queue)
    {
        $queueClass = get_class($queue);
        $this->_queue = $queue;
        $this->_queueClass = $queueClass;
        $this->_connected = true;

        return true;
    }

    /**
     * Query the class name of the Queue object for which this
     * Message was created.
     *
     * @return string
     */
    public function getQueueClass()
    {
        return $this->_queueClass;
    }

    /**
     * Returns the column/value data as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->_data;
    }

    /**
     * Sets all data in the row from an array.
     *
     * @return Zend_Queue_Message Provides a fluent interface
     */
    public function setFromArray(array $data)
    {
        foreach ($data as $columnName => $value) {
            $this->$columnName = $value;
        }

        return $this;
    }
}
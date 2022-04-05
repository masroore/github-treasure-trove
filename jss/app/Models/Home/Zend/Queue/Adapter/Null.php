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
 * @version    $Id: Null.php 24593 2012-01-05 20:35:02Z matthew $
 */

/**
 * @see Zend_Queue_Adapter_AdapterAbstract
 */
require_once 'Zend/Queue/Adapter/AdapterAbstract.php';

/**
 * Class testing.  No supported functions.  Also used to disable a Zend_Queue.
 *
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Queue_Adapter_Null extends Zend_Queue_Adapter_AdapterAbstract
{
    /**
     * Constructor.
     *
     * @param  array|Zend_Config $options
     */
    public function __construct($options, ?Zend_Queue $queue = null)
    {
        parent::__construct($options, $queue);
    }

    // Queue management functions

    /**
     * Does a queue already exist?
     */
    public function isExists($name): void
    {
        require_once 'Zend/Queue/Exception.php';

        throw new Zend_Queue_Exception(__FUNCTION__ . '() is not supported by ' . static::class);
    }

    /**
     * Create a new queue.
     */
    public function create($name, $timeout = null): void
    {
        require_once 'Zend/Queue/Exception.php';

        throw new Zend_Queue_Exception(__FUNCTION__ . '() is not supported by ' . static::class);
    }

    /**
     * Delete a queue and all of it's messages.
     */
    public function delete($name): void
    {
        require_once 'Zend/Queue/Exception.php';

        throw new Zend_Queue_Exception(__FUNCTION__ . '() is not supported by ' . static::class);
    }

    /**
     * Get an array of all available queues.
     */
    public function getQueues(): void
    {
        require_once 'Zend/Queue/Exception.php';

        throw new Zend_Queue_Exception(__FUNCTION__ . '() is not supported by ' . static::class);
    }

    /**
     * Return the approximate number of messages in the queue.
     */
    public function count(?Zend_Queue $queue = null): void
    {
        require_once 'Zend/Queue/Exception.php';

        throw new Zend_Queue_Exception(__FUNCTION__ . '() is not supported by ' . static::class);
    }

    // Messsage management functions

    /**
     * Send a message to the queue.
     */
    public function send($message, ?Zend_Queue $queue = null): void
    {
        require_once 'Zend/Queue/Exception.php';

        throw new Zend_Queue_Exception(__FUNCTION__ . '() is not supported by ' . static::class);
    }

    /**
     * Get messages in the queue.
     */
    public function receive($maxMessages = null, $timeout = null, ?Zend_Queue $queue = null): void
    {
        require_once 'Zend/Queue/Exception.php';

        throw new Zend_Queue_Exception(__FUNCTION__ . '() is not supported by ' . static::class);
    }

    /**
     * Delete a message from the queue.
     */
    public function deleteMessage(Zend_Queue_Message $message): void
    {
        require_once 'Zend/Queue/Exception.php';

        throw new Zend_Queue_Exception(__FUNCTION__ . '() is not supported by ' . static::class);
    }

    // Supporting functions

    /**
     * Return a list of queue capabilities functions.
     *
     * $array['function name'] = true or false
     * true is supported, false is not supported.
     *
     * @return array
     */
    public function getCapabilities()
    {
        return [
            'create' => false,
            'delete' => false,
            'send' => false,
            'receive' => false,
            'deleteMessage' => false,
            'getQueues' => false,
            'count' => false,
            'isExists' => false,
        ];
    }
}

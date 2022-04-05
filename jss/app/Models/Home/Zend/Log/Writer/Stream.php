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
 * @version    $Id: Stream.php 24593 2012-01-05 20:35:02Z matthew $
 */

/** Zend_Log_Writer_Abstract */
require_once 'Zend/Log/Writer/Abstract.php';

/** Zend_Log_Formatter_Simple */
require_once 'Zend/Log/Formatter/Simple.php';

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 * @version    $Id: Stream.php 24593 2012-01-05 20:35:02Z matthew $
 */
class Zend_Log_Writer_Stream extends Zend_Log_Writer_Abstract
{
    /**
     * Holds the PHP stream to log to.
     *
     * @var null|stream
     */
    protected $_stream;

    /**
     * Class Constructor.
     *
     * @param array|resource|string $streamOrUrl Stream or URL to open as a stream
     * @param null|string $mode Mode, only applicable if a URL is given
     */
    public function __construct($streamOrUrl, $mode = null)
    {
        // Setting the default
        if (null === $mode) {
            $mode = 'a';
        }

        if (is_resource($streamOrUrl)) {
            if (get_resource_type($streamOrUrl) != 'stream') {
                require_once 'Zend/Log/Exception.php';

                throw new Zend_Log_Exception('Resource is not a stream');
            }

            if ($mode != 'a') {
                require_once 'Zend/Log/Exception.php';

                throw new Zend_Log_Exception('Mode cannot be changed on existing streams');
            }

            $this->_stream = $streamOrUrl;
        } else {
            if (is_array($streamOrUrl) && isset($streamOrUrl['stream'])) {
                $streamOrUrl = $streamOrUrl['stream'];
            }

            if (!$this->_stream = @fopen($streamOrUrl, $mode, false)) {
                require_once 'Zend/Log/Exception.php';
                $msg = "\"$streamOrUrl\" cannot be opened with mode \"$mode\"";

                throw new Zend_Log_Exception($msg);
            }
        }

        $this->_formatter = new Zend_Log_Formatter_Simple();
    }

    /**
     * Create a new instance of Zend_Log_Writer_Stream.
     *
     * @param  array|Zend_Config $config
     *
     * @return Zend_Log_Writer_Stream
     */
    public static function factory($config)
    {
        $config = self::_parseConfig($config);
        $config = array_merge([
            'stream' => null,
            'mode' => null,
        ], $config);

        $streamOrUrl = $config['url'] ?? $config['stream'];

        return new self(
            $streamOrUrl,
            $config['mode']
        );
    }

    /**
     * Close the stream resource.
     */
    public function shutdown(): void
    {
        if (is_resource($this->_stream)) {
            fclose($this->_stream);
        }
    }

    /**
     * Write a message to the log.
     *
     * @param  array  $event  event data
     */
    protected function _write($event): void
    {
        $line = $this->_formatter->format($event);

        if (false === @fwrite($this->_stream, $line)) {
            require_once 'Zend/Log/Exception.php';

            throw new Zend_Log_Exception('Unable to write to stream');
        }
    }
}

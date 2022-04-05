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
 * @version    $Id: Writer.php 25024 2012-07-30 15:08:15Z rob $
 */

/**
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Config_Writer
{
    /**
     * Option keys to skip when calling setOptions().
     *
     * @var array
     */
    protected $_skipOptions = [
        'options',
    ];

    /**
     * Config object to write.
     *
     * @var Zend_Config
     */
    protected $_config;

    /**
     * Create a new adapter.
     *
     * $options can only be passed as array or be omitted
     */
    public function __construct(?array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Set options via a Zend_Config instance.
     *
     * @return Zend_Config_Writer
     */
    public function setConfig(Zend_Config $config)
    {
        $this->_config = $config;

        return $this;
    }

    /**
     * Set options via an array.
     *
     * @return Zend_Config_Writer
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            if (in_array(strtolower($key), $this->_skipOptions)) {
                continue;
            }

            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    /**
     * Write a Zend_Config object to it's target.
     */
    abstract public function write(): void;
}

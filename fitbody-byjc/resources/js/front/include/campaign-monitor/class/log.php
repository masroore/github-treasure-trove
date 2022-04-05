<?php

define('CS_REST_LOG_VERBOSE', 1000);
define('CS_REST_LOG_WARNING', 500);
define('CS_REST_LOG_ERROR', 250);
define('CS_REST_LOG_NONE', 0);

class log
{
    public $_level;

    public function __construct($level)
    {
        $this->_level = $level;
    }

    public function log_message($message, $module, $level): void
    {
        if ($this->_level >= $level) {
            echo date('G:i:s') . ' - ' . $module . ': ' . $message . "<br />\n";
        }
    }
}

<?php

if (!class_exists('Services_JSON', false)) {
    require_once __DIR__ . '/services_json.php';
}

function CS_REST_SERIALISATION_get_available($log)
{
    $log->log_message('Getting serialiser', __FUNCTION__, CS_REST_LOG_VERBOSE);
    if (function_exists('json_decode') && function_exists('json_encode')) {
        return new CS_REST_NativeJsonSerialiser($log);
    }

    return new CS_REST_ServicesJsonSerialiser($log);
}
class CS_REST_BaseSerialiser
{
    public $_log;

    public function __construct($log)
    {
        $this->_log = $log;
    }

    /**
     * Recursively ensures that all data values are utf-8 encoded.
     *
     * @param array $data all values of this array are checked for utf-8 encoding
     */
    public function check_encoding($data)
    {
        foreach ($data as $k => $v) {
            // If the element is a sub-array then recusively encode the array
            if (is_array($v)) {
                $data[$k] = $this->check_encoding($v);
            // Otherwise if the element is a string then we need to check the encoding
            } elseif (is_string($v)) {
                if ((function_exists('mb_detect_encoding') && 'UTF-8' !== mb_detect_encoding($v)) ||
                   (function_exists('mb_check_encoding') && !mb_check_encoding($v, 'UTF-8'))) {
                    // The string is using some other encoding, make sure we utf-8 encode
                    $v = utf8_encode($v);
                }

                $data[$k] = $v;
            }
        }

        return $data;
    }
}

class CS_REST_DoNothingSerialiser extends CS_REST_BaseSerialiser
{
    public function __construct()
    {
    }

    public function get_type()
    {
        return 'do_nothing';
    }

    public function serialise($data)
    {
        return $data;
    }

    public function deserialise($text)
    {
        $data = json_decode($text);

        return null === $data ? $text : $data;
    }

    public function check_encoding($data)
    {
        return $data;
    }
}

class CS_REST_NativeJsonSerialiser extends CS_REST_BaseSerialiser
{
    public function __construct($log)
    {
        parent::__construct($log);
    }

    public function get_format()
    {
        return 'json';
    }

    public function get_type()
    {
        return 'native';
    }

    public function serialise($data)
    {
        if (null === $data || '' == $data) {
            return '';
        }

        return json_encode($this->check_encoding($data));
    }

    public function deserialise($text)
    {
        $data = json_decode($text);

        return $this->strip_surrounding_quotes(null === $data ? $text : $data);
    }

    /**
     * We've had sporadic reports of people getting ID's from create routes with the surrounding quotes present.
     * There is no case where these should be present. Just get rid of it.
     */
    public function strip_surrounding_quotes($data)
    {
        if (is_string($data)) {
            return trim($data, '"');
        }

        return $data;
    }
}

class CS_REST_ServicesJsonSerialiser extends CS_REST_BaseSerialiser
{
    public $_serialiser;

    public function __construct($log)
    {
        parent::__construct($log);
        $this->_serialiser = new Services_JSON();
    }

    public function get_content_type()
    {
        return 'application/json';
    }

    public function get_format()
    {
        return 'json';
    }

    public function get_type()
    {
        return 'services_json';
    }

    public function serialise($data)
    {
        if (null === $data || '' == $data) {
            return '';
        }

        return $this->_serialiser->encode($this->check_encoding($data));
    }

    public function deserialise($text)
    {
        $data = $this->_serialiser->decode($text);

        return null === $data ? $text : $data;
    }
}

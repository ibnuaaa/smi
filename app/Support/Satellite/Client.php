<?php

namespace App\Support\Satellite;

use GuzzleHttp;

class Client
{
    /**
     * The Instance Message Object.
     *
     * @var \Message
     */
    protected static $_Instance = NULL;

    /**
     * The Request Http Instance.
     *
     * @var array
     */
    protected $_Request = null;

    /**
     * The result.
     *
     * @var array
     */
    protected $_Result = null;

    public function __construct()
    {
        $this->_Request = new GuzzleHttp\Client([
            'base_uri' => 'https://' . env('HOST_SERVICE_PROVIDER_SCORE'),
            'headers' => [
                'Content-Type' => 'application/json',
                'APIKey' => '1234567890',
                'token' => 'C4R8J3X88YWHK17IEM9LMN4DDRD6UA06L7N5SIEQN9OQ30KS123D0WJQV4FDEXFT6KNDKL82VXCQOO6EUGKU7KWHC3I7GTKTUB4OMTVX0G3OLP4PLZ7MICBIN5K0FTVP9GEAH1BUWNIS917X2PTY5VCHHOP1MRM',
                'user' => 'admin'
            ]
        ]);
        return $this;
    }

    public function Request()
    {
        return $this->_request;
    }

    public static function get($url)
    {
        if (static::$_Instance == NULL) {
            static::$_Instance = new self();
        }
        return static::$_Instance->_GET($url);
    }

    public static function post($url, $postOption)
    {
        if (static::$_Instance == NULL) {
            static::$_Instance = new self();
        }
        return static::$_Instance->_POST($url, $postOption);
    }

    public function _GET($url)
    {
        $result = [];
        try {
            $response = $this->_Request->get($url);
            $BodyObject = json_decode($response->getBody());
            $result = $BodyObject;
        } catch (\Exception $e) {
        }
        $this->_Result = $result;
        return $this;
    }

    public function _POST($url, $postOption)
    {
        $result = [];
        try {
            $response = $this->_Request->post($url, $postOption);
            $BodyObject = json_decode($response->getBody(), true);
            $result = $BodyObject;
        } catch (\Exception $e) {
        }
        $this->_Result = $result;
        return $this;
    }

    public function result()
    {
        return $this;
    }

    public function show()
    {
        try {
            return $this->_Result->data;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function data()
    {
        try {
            return collect($this->_Result);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getOutData()
    {
        try {
            return collect($this->_Result['OUT_DATA']);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getOutMess()
    {
        try {
            return collect($this->_Result['OUT_MESS']);
        } catch (\Exception $e) {
            return null;
        }
    }
}

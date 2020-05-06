<?php

namespace App\Support\Realtime;

use Pusher\Pusher;

abstract class Realtime
{
    /**
     * The Pusher instance.
     *
     * @var \Pusher
     */
    protected static $Pusher;

    /**
     * Pusher Option.
     *
     * @var array
     */
    protected $PusherOption = ['cluster' => 'ap1', 'useTLS' => true];

    /**
     * The AppId for the Pusher.
     *
     * @var string
     */
    protected static $PuserAppId;

    /**
     * The Key for the Pusher.
     *
     * @var string
     */
    protected static $PuserKey;

    /**
     * The Secret for the Pusher.
     *
     * @var string
     */
    protected static $PuserSecret;

    /**
     * Create a new Realtime model.
     *
     * @return $this
     */
    public function __construct()
    {
        return $this->Sync();
    }

    /**
     * Set Synchronize Object Instance.
     *
     * @return $this
     */
    public function Sync()
    {
        $this->Pusher();
        return $this;
    }

    /**
     * New Pusher Instance.
     *
     * @return static
     */
    public function Pusher()
    {
        return static::$Pusher = new Pusher(static::$PuserKey, static::$PuserSecret, static::$PuserAppId, $this->PusherOption);
    }

    /**
     * Set Pusher App Id Value.
     *
     * @param $AppId
     * @return string
     */
    public static function PusherAppId($AppId)
    {
        return static::$PuserAppId = $AppId;
    }

    /**
     * Set Pusher Key Value.
     *
     * @param $PuserKey
     * @return string
     */
    public static function PusherKey($PuserKey)
    {
        return static::$PuserKey = $PuserKey;
    }

    /**
     * Set Pusher Secret Value.
     *
     * @param $PuserSecret
     * @return string
     */
    public static function PusherSecret($PuserSecret)
    {
        return static::$PuserSecret = $PuserSecret;
    }

    /**
     * Get Pusher App Id Value.
     *
     * @param $AppId
     * @return string
     */
    public static function GetPusherAppId()
    {
        return static::$PuserAppId;
    }

    /**
     * Get Pusher Key Value.
     *
     * @param $PuserKey
     * @return string
     */
    public static function GetPusherKey()
    {
        return static::$PuserKey;
    }

    /**
     * Get Pusher Secret Value.
     *
     * @param $PuserSecret
     * @return string
     */
    public static function GetPusherSecret()
    {
        return static::$PuserSecret;
    }
}

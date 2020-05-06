<?php

namespace App\Support\Realtime;

use App\Support\Realtime\Realtime;

class Sniper extends Realtime
{
    /**
     * The Instance Sniper Object.
     *
     * @var \Sniper
     */
    protected static $Instance = NULL;

    /**
     * The Target Shot From Sniper.
     *
     * @var array
     */
    protected $Target = [];

    /**
     * The Event To Listen.
     *
     * @var array
     */
    protected $Event = [];

    /**
     * The data from server to client, so client will be understand what it is.
     *
     * @var array
     */
    protected $Data = [];

    /**
     * Init Message Setup.
     *
     * @param array  $Args
     * @return static
     */
    public static function message($data)
    {
        if (static::$Instance == NULL) {
            static::$Instance = new self();
        }
        if ($data) {
            static::$Instance->Data = $data;
        }
        return static::$Instance;
    }

    /**
     * Set Target To Pusher When Sniper ready to Shot.
     *
     * @param string  $Target
     * @return $this
     */
    public function Target($Channel = NULL)
    {
        $this->Channel = $Channel;
        return $this;
    }

    /**
     * Set Target To Pusher When Sniper ready to Shot.
     *
     * @param string  $Target
     * @return $this
     */
    public function Event($Event = NULL)
    {
        $this->Event = $Event;
        return $this;
    }

    /**
     * Shot Pusher Sniper.
     *
     * @return $this
     */
    public function Shot()
    {
        // dd($this->Channel, $this->Event, $this->Data);
        static::$Pusher->trigger($this->Channel, $this->Event, $this->Data);
        return $this;
    }
}

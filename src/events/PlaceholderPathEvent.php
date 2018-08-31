<?php

namespace bertoost\placeholderurl\events;

use yii\base\Event;

/**
 * Class PlaceholderPathEvent
 */
class PlaceholderPathEvent extends Event
{
    /**
     * @var array
     */
    public $paths = [];
}

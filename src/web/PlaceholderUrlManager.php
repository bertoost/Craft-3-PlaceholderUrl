<?php

namespace bertoost\placeholderurl\web;

use bertoost\placeholderurl\events\PlaceholderPathEvent;
use craft\web\UrlManager;

/**
 * Class PlaceholderUrlManager
 */
class PlaceholderUrlManager extends UrlManager
{
    const EVENT_REGISTER_PLACEHOLDER_PATHS = 'onRegisterPlaceholderPath';

    /**
     * @var array List of loaded registered path keys -> paths
     */
    private $loadedPaths = [];

    /**
     * Loads placeholder paths
     */
    public function loadPaths()
    {
        if (empty($this->loadedPaths)) {

            $event = new PlaceholderPathEvent();
            $this->onPlaceholderPaths($event);

            $this->loadedPaths = array_merge($this->loadedPaths, $event->paths);
        }
    }

    /**
     * Find registered path by key and returns the actual path
     *
     * @param string $search
     *
     * @return mixed|null
     */
    public function replacePlaceholderPath($search)
    {
        $this->loadPaths();

        if (!empty($this->loadedPaths)) {
            foreach ($this->loadedPaths as $key => $path) {
                if ($search === $key) {

                    return $path;
                }
            }
        }

        return $search;
    }

    /**
     * @param PlaceholderPathEvent $event
     */
    public function onPlaceholderPaths(PlaceholderPathEvent $event)
    {
        if ($this->hasEventHandlers(self::EVENT_REGISTER_PLACEHOLDER_PATHS)) {
            $this->trigger(self::EVENT_REGISTER_PLACEHOLDER_PATHS, $event);
        }
    }
}

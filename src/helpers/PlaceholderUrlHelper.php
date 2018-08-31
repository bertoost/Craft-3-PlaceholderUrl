<?php

namespace bertoost\placeholderurl\helpers;

use craft\helpers\UrlHelper;

/**
 * Class PlaceholderUrlHelper
 */
class PlaceholderUrlHelper extends UrlHelper
{
    /**
     * {@inheritdoc}
     */
    public static function url(string $path = '', $params = null, string $scheme = null, bool $showScriptName = null): string
    {
        self::replacePlaceholders($path, $params, '<', '>');
        self::replacePlaceholders($path, $params);

        return parent::url($path, $params, $scheme, $showScriptName);
    }

    /**
     * {@inheritdoc}
     */
    public static function siteUrl(string $path = '', $params = null, string $scheme = null, int $siteId = null): string
    {
        self::replacePlaceholders($path, $params, '<', '>');
        self::replacePlaceholders($path, $params);

        return parent::url($path, $params, $scheme, $siteId);
    }

    /**
     * {@inheritdoc}
     */
    public static function cpUrl(string $path = '', $params = null, string $scheme = null): string
    {
        self::replacePlaceholders($path, $params, '<', '>');
        self::replacePlaceholders($path, $params);

        return parent::cpUrl($path, $params, $scheme);
    }

    /**
     * @param string     $path
     * @param array|null $params
     * @param string     $start
     * @param string     $end
     */
    private static function replacePlaceholders(&$path, &$params = null, $start = '{', $end = '}')
    {
        if (stristr($path, $start) !== false
            && stristr($path, $end) !== false
            && is_array($params) && !empty($params)
        ) {
            $placeholders = [];
            foreach ((array)$params as $name => $value) {
                $key = $start . $name . $end;
                $placeholders[$key] = $value;

                if (strstr($path, $key) !== false) {
                    unset($params[$name]);
                }
            }

            $path = strtr($path, $placeholders);
        }
    }
}

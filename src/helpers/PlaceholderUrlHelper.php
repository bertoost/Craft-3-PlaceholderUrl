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
        self::replacePlaceholders($path, $params);

        return parent::url($path, $params, $scheme, $showScriptName);
    }

    /**
     * {@inheritdoc}
     */
    public static function siteUrl(string $path = '', $params = null, string $scheme = null, int $siteId = null): string
    {
        self::replacePlaceholders($path, $params);

        return parent::url($path, $params, $scheme, $siteId);
    }

    /**
     * {@inheritdoc}
     */
    public static function cpUrl(string $path = '', $params = null, string $scheme = null): string
    {
        self::replacePlaceholders($path, $params);

        return parent::cpUrl($path, $params, $scheme);
    }

    /**
     * @param string     $path
     * @param array|null $params
     */
    private static function replacePlaceholders(&$path, &$params = null)
    {
        if (stristr($path, '{') !== false
            && stristr($path, '}') !== false
            && is_array($params) && !empty($params)
        ) {
            foreach ($params as $key => $value) {

                $tag = sprintf('{%s}', $key);
                if (stristr($path, $tag) !== false) {

                    $path = str_replace($tag, $value, $path);
                    unset($params[$key]);
                }
            }

            // set back to NULL, when empty
            if (empty($params)) {
                $params = null;
            }
        }
    }
}

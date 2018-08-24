<?php

namespace bertoost\placeholderurl\twig;

use bertoost\placeholderurl\helpers\PlaceholderUrlHelper;

/**
 * Class TwigPlaceholderUrlExtension
 */
class TwigPlaceholderUrlExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('url', [$this, 'placeholderUrl']),
            new \Twig_SimpleFunction('siteUrl', [$this, 'placeholderSiteUrl']),
            new \Twig_SimpleFunction('cpUrl', [$this, 'placeholderCpUrl']),
        ];
    }

    /**
     * @param string      $path
     * @param array|null  $params
     * @param string|null $scheme
     * @param bool|null   $showScriptName
     *
     * @return string
     */
    public function placeholderUrl(string $path, $params = null, string $scheme = null, bool $showScriptName = null): string
    {
        return PlaceholderUrlHelper::url($path, $params, $scheme, $showScriptName);
    }

    /**
     * @param string      $path
     * @param array|null  $params
     * @param string|null $scheme
     * @param int|null    $siteId
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public function placeholderSiteUrl(string $path, $params = null, string $scheme = null, int $siteId = null): string
    {
        return PlaceholderUrlHelper::siteUrl($path, $params, $scheme, $siteId);
    }

    /**
     * @param string      $path
     * @param array|null  $params
     * @param string|null $scheme
     *
     * @return string
     */
    public function placeholderCpUrl(string $path, $params = null, string $scheme = null): string
    {
        return PlaceholderUrlHelper::cpUrl($path, $params, $scheme);
    }
}

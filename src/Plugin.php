<?php

namespace bertoost\placeholderurl;

use Craft;
use bertoost\placeholderurl\twig\TwigPlaceholderUrlExtension;

/**
 * Class Plugin
 */
class Plugin extends \craft\base\Plugin
{
    /**
     * @var string
     */
    public $changelogUrl = 'https://raw.githubusercontent.com/bertoost/Craft-3-PlaceholderUrl/master/CHANGELOG.md';

    /**
     * @var string
     */
    public $downloadUrl = 'https://github.com/bertoost/Craft-3-PlaceholderUrl/archive/master.zip';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Craft::setAlias('@plugins/placeholderurls', $this->getBasePath());

        $extension = new TwigPlaceholderUrlExtension();
        Craft::$app->view->registerTwigExtension($extension);
    }
}

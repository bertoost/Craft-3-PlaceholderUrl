<?php

namespace bertoost\placeholderurl;

use bertoost\placeholderurl\web\PlaceholderUrlManager;
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
        Craft::setAlias('@plugins/placeholderurls', $this->getBasePath());
        parent::init();

        $this->setComponents([
            'urlManager' => PlaceholderUrlManager::class
        ]);

        // register Twig extension
        $extension = new TwigPlaceholderUrlExtension();
        Craft::$app->view->registerTwigExtension($extension);
    }

    /**
     * @return PlaceholderUrlManager|object
     * @throws \yii\base\InvalidConfigException
     */
    public function getUrlManager(): PlaceholderUrlManager
    {
        return $this->get('urlManager');
    }
}

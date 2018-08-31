# Placeholder Paths

## Explanation

Ever made a serious website with a couple of features on URLs you provide (as developer)? Like a website with a frontend login and features like a messages system, or posting blog posts.

Your Craft CMS based application can come with a lot of URLs, defined in `config/routes.php` and you have to write them all the time in your templates, controllers etc.

This can be horrifying when you're heavily in development and continuously decide to change paths of the different pages in your application.

__A common mistake is that you forget to change a route in one of the calls you do to create paths. Like redirects, or hyperlinks. Avoid that using placeholder paths!__

## What are placeholder paths

A placeholder path should be a nice rememberable name, referencing the URL you want to create. For example, if your application is using an account dashboard page, and you decide to place it on `{siteUrl}/account` URL. You don't want to link all your stuff to `{siteUrl}/account`.

The placeholder for this URL can be something like `account.dashboard`. A nice name which is easy to remember and much cleaner.

## Registering paths

Unfortunate Craft (or Yii) doesn't understand these kind of placeholder paths for your URLs. So, here comes our plugin to rescue. Once you installed the plugin, your Twig functions, and PHP methods should be replaced by this plugin features. [See more details here](PlaceholderUrls.md).

```php
// don't forget to use the next two classes
use bertoost\placeholderurl\events\PlaceholderPathEvent;
use bertoost\placeholderurl\web\PlaceholderUrlManager;

// somewhere
Event::on(
    PlaceholderUrlManager::class,
    PlaceholderUrlManager::EVENT_REGISTER_PLACEHOLDER_PATHS,
    function (PlaceholderPathEvent $event) {
        $event->paths['a.path.placeholder'] = 'replaced/{placeholder}/paths';
    }
);
```

## How to

### 1. Create a application wide module

__If you don't already have!__

For example, let's call it the `App` module.

1. Ensure your `composer.json` has this autoload part included (if not, add or change it and run `composer install` again)

```json
"autoload": {
  "psr-4": {
    "modules\\": "modules/"
  }
},
```

2. Create a `app/` folder inside the root `modules/` folder
3. Create a `Module` class inside the new folder.

```php
namespace modules\app;

use yii\base\Module as BaseModule;

/**
 * Class Module
 */
class Module extends BaseModule
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        Craft::setAlias('@modules/app', $this->getBasePath());

        // custom code goes here...
    }
}
```

### 2. Create a helper to define your paths/routes

__Note:__ That here we assume you have a app-wide module where you can put things in.

```php

namespace modules\app\helpers;

/**
 * Class AppRouteHelper
 */
class AppRouteHelper
{
    static $routes = [
        'account'       => [
            'path'  => 'account',
            'value' => 'app/dashboard/index',
        ],
        'account.register' => [
            'path'  => 'account/register',
            'value' => ['template' => 'app/register'],
        ],
    ];

    /**
     * Returns the route list for the application config setup
     *
     * @return array
     */
    public static function getRoutes()
    {
        $list = [];
        foreach (self::$routes as $key => $config) {
            $list[$config['path']] = $config['value'];
        }

        return $list;
    }
}
```

### 3. Add an event listener to register the routes in Craft

In your app `Module` class. You don't have to use `config/routes.php` for this.

```php
use craft\events\RegisterUrlRulesEvent;
use craft\web\UrlManager;
use modules\helpers\AppRouteHelper;

public function init()
{
    // ...

    Event::on(
        UrlManager::class,
        UrlManager::EVENT_REGISTER_SITE_URL_RULES,
        function (RegisterUrlRulesEvent $event) {
            foreach (AppRouteHelper::getRoutes() as $path => $value) {
                $event->rules[$path] = $value;
            }
        }
    );
}
```

### 4. Add the event listener to register your placeholder paths

In your app `Module` class

```php
use bertoost\placeholderurl\events\PlaceholderPathEvent;
use bertoost\placeholderurl\web\PlaceholderUrlManager;
use modules\helpers\AppRouteHelper;

public function init()
{
    // ...

    Event::on(
        PlaceholderUrlManager::class,
        PlaceholderUrlManager::EVENT_REGISTER_PLACEHOLDER_PATHS,
        function (PlaceholderPathEvent $event) {
            foreach (AppRouteHelper::getRoutes() as $path => $value) {
                $event->rules[$path] = $value;
            }
        }
    );
}
```

### 5. Use the placeholder paths in your templates/php code

In Twig:

```twig
{{ url('account') }}
{{ url('account.register') }}
```

In PHP:

```php
use bertoost\placeholderurl\helpers\PlaceholderUrlHelper;

PlaceholderUrlHelper::url('account');
PlaceholderUrlHelper::url('account.register');
```

## Target URL has route parameters

Even if your target url, like `account/register` has some route parameters, like `account/<handle>/details`, your can easily provide these paramaters. An example of that will look like;

In Twig:

```twig
{{ url('account.details', { handle: 'something' }) }}
```

In PHP:

```php
use bertoost\placeholderurl\helpers\PlaceholderUrlHelper;

PlaceholderUrlHelper::url('account.details', ['handle' => 'something']);
```
# Craft CMS 3 - PlaceholderUrl

A simple solution for a writing and reading issue when having long URLs in your Twig templates. Using placeholders to be defined and parameters given to replace with.

## Explanation

When you have a long url, like this;

```twig
{{ url('this/is/my/custom/url/to/a/detail/page/of/my/news') }}
```

There is not a big deal. But when the URL will contain a couple of dynamic parts, you have to write concatenates in Twig like this;

```twig
{{ url('this/' ~ entry.slug ~ '/url/to/' ~ someOtherUrlVar ~ '/of/my/' ~ entry.section.handle) }}
```

## Using placeholders

Using placeholders instead of concatenating strings together, it will looks like this;

```twig
{{ url('this/{slug}/url/to/{var}/of/my/{handle}', {
    slug: entry.slug,
    var: someOtherVar,
    handle: entry.section.handle
}) }}
```

Easy, right?!

## Supported Twig functions

- `{{ url() }}`
- `{{ siteUrl() }}`
- `{{ cpUrl() }}`

## Support for PHP

I couldn't overwrite the `UrlHelper` class, but I have added an own helper to help you in PHP.

```php
// don't forget to use it
use bertoost\placeholderurl\helpers\PlaceholderUrlHelper;

// from your code
$url = PlaceholderUrlHelper::url('this/{slug}/url/to/{var}/of/my/{handle}', [
    'slug'   => $entry->slug,
    'var'    => $someOtherVar,
    'handle' => $entry->section->handle,
]);
```

_Note:_ It also can do all the other things the `UrlHelper` can, since `PlaceholderUrlHelper` extends it.
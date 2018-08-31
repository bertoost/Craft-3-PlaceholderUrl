# Craft CMS 3 - PlaceholderUrl

A simple solution for a writing and reading issue when having long URLs in your Twig templates. Using placeholders to be defined and parameters given to replace with.

## Placeholder URLs

These helpers are here to generate urls, with placeholders replaced by actual values.

```twig
{# generates: 'a/placeholder/path' #}
{{ url('a/{phs}/path', { phs: 'placeholder' }) }}
```

[Read more here](docs/PlaceholderUrls.md)

## Placeholder paths

A more advanced usage for Craft CMS based applications without using hard-coded URLs. Which are even hard to remember all the time.

```php
// register paths in php via an event listener
$paths['account.dashboard'] = 'account';
$paths['account.sub.details'] = 'account/<uid>/details';
```

```twig
{# calling them in Twig #}
{{ url('account.dashboard') }}
{{ url('account.sub.detail', { uid: '199f3fae-acfe-11e8-98d0-529269fb1459' }) }}
```

[Read more here](docs/PlaceholderPaths.md)

# Publish assets

{% hint style="success" %}
Using the Starter Kit? Normally you don't need to worry about publishing assets then. 
{% endhint %}

_butik_ will automatically publish the following assets during installation:

* Config file
* Images
* resources

The resources \(javascript file for the control panel and css file for the frontend\) will be forced to overwrite existing files. 

To avoid 

## Config

```text
php artisan vendor:publish --tag="butik-config"
```

Will be published to `config/butik.php`

The config file will automatically be published during the installation process. In case of updates, you need to change the config file manually. 

## Views

```text
php artisan vendor:publish --tag="butik-views"
```

{% hint style="success" %}
Use our templates as your starting point
{% endhint %}

Will be published to `resources/views/vendor/butik/`

The views will automatically be published during the installation process. In case of updates, you need to change the views manually.

## Images

```text
php artisan vendor:publish --tag="butik-images"
```

Want to use our SVGs or replace them?

Will be published to `public/vendor/butik/images/`

## Language files

```text
php artisan vendor:publish --tag="butik-lang"
```

If you want to add or edit language files. 

Will be published to `/resources/lang/`

## All assets

```text
php artisan vendor:publish --provider="Jonassiewertsen\StatamicButik\StatamicButikServiceProvider"
```

This command will publish all available assets


# EnhancedConnectorBundle

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/akeneo-labs/EnhancedConnectorBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/akeneo-labs/EnhancedConnectorBundle/?branch=master)
[![Build Status](https://travis-ci.org/akeneo-labs/EnhancedConnectorBundle.svg?branch=master)](https://travis-ci.org/akeneo-labs/EnhancedConnectorBundle)

This bundle adds some new exports to Akeneo:

 - Enhanced product export: choose if you want to export all products, products modified since a specific date or modified since the last export.

## Requirements

| EnhancedConnectorBundle | Akeneo PIM Community Edition |
|:-----------------------:|:----------------------------:|
| v1.2.*                  | v1.5.*                       |
| v1.1.*                  | v1.4.*                       |
| v1.0.*                  | v1.3.*                       |


## Installation

Install the bundle with composer:

```bash
    php composer.phar require akeneo-labs/pim-enhanced-connector:~1.2
```

Enable the bundle in the `app/AppKernel.php` file:

```php
    public function registerBundles()
    {
        $bundles = [
            new Pim\Bundle\EnhancedConnectorBundle\PimEnhancedConnectorBundle()
        ]

        // ...

        return $bundles;
    }
```

Now let's clean your cache and dump your assets:

```bash
    php app/console cache:clear --env=prod
    php app/console pim:installer:assets --env=prod
```


## Documentation

### Configuration

All these exports are configured like standards CSV Akeneo exports: you need to define a delimitor
(the character separating the elements on a same line), an enclosure (for instance, if a label contain spaces,
it needs to be enclose to avoid import errors), if you want headers in your file, and the file path to save your export.

However, the family and the product exports adds a few new configuration fields, as explained below.

### Family export

You need to choose which in which language you want to export the family label, as PimGento needs only one label
(ideally, the language should correspond to the Magento locale for the administration interface).

### Product export

Like with the standard product export, you need to define a channel to export from,
as your products could be different from a channel to another.

However, the standard product export allows only to export complete, enable and categorized products.
The enhanced export allows you to chose if you want to export only enable, only disable or both, only complete,
only incomplete or both, and finaly only categorized, only uncategorized or both.

You can also choose to export the products updated since the last time you run the job,
since a precise date that you give in the configuration, or regardless of their last update (i.e. all the products).

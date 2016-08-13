# Scheduled Pages, version 1.0.0

## Overview

This module can be used to set specific dates for pages to be enabled or disabled.

## Installation

For this installation of this module, you must use composer.
1. In your Magento 2 composer.json file, add this repository:
```
{
    "repositories": [
        {
            "type": "git",
            "url": "git@github.com:catalinmoiceanu/module-scheduledpages.git"
        }
    ],
}
```
2. After you save the file, run the following commands from your terminal to add this module to your project:
```
cd MAGENTO_ROOT
composer require catalinmoiceanu/module-scheduledpages
```
3. Regenerate the DI configuration:
```
cd MAGENTO_ROOT
php bin/magento setup:di:compile
```
4. Clean cache
```
cd MAGENTO_ROOT
php bin/magento cache:clean
```

## Administration

This module will add a new tab to the Page edit view, called "Schedule".

In here you can set up a starting date for the page to be enabled, and a end date, after which the page should be disabled.

There are 4 ways you can set this up:
- If you fill both fields, the page will only be enabled during that period of time.
- If you fill only the start date, the page will be enabled starting with the date set.
- If you fill only the end date, the page will be disabled after the date set.
- If you do not fill anything, the page status will not be changed at any point in time.

A cron job will run every day at 00:01 and take the necessary actions based on the status and schedule of the pages.

## Tests

This module's tests will run along with the other Magento 2 tests - you can find out more about this ([here](http://devdocs.magento.com/guides/v2.0/config-guide/cli/config-cli-subcommands-test.html))
To test only this module, you can do the following:
```
cd MAGENTO_ROOT/dev/tests/unit
php ../../../vendor/phpunit/phpunit/phpunit --group="CatalinMoiceanu_ScheduledPages"
```

## Contributors

Any pull request meant to fix an issue is welcome.

## License

This extension is released under MIT License
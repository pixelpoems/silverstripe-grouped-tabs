# Silverstripe Grouped Tabs Module
[![stability-beta](https://img.shields.io/badge/stability-beta-33bbff.svg)](https://github.com/mkenney/software-guides/blob/master/STABILITY-BADGES.md#beta)



* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)

## Requirements

* Silverstripe CMS ^6.0

## Installation
```
composer require pixelpoems/silverstripe-grouped-tabs
```

## Usage
```php
<?php
namespace App\Admins;

use Pixelpoems\GroupedTabs\Admins\GroupedModelAdmin;

class MyAdmin extends GroupedModelAdmin
{
    private static string $url_segment = 'myadmin';

    private static string $menu_title = 'MyAdmin';

    private static array $managed_models = [
        DataObject1::class,
        DataObject2::class,
        DataObject3::class,
        'project' => [
            'title' => 'Project',
            'dataClasses' => [
                ProjectDataObject1::class,
                ProjectDataObject2::class,
                ProjectDataObject3::class,
                ProjectDataObject4::class,
            ]
        ],
        DataObject4::class,
        DataObject5::class,
        DataObject6::class,
        DataObject7::class,
        'grouped' => [
            'title' => 'Grouped',
            'dataClasses' => [
                GroupedDataObject1::class,
                GroupedDataObject2::class,
            ]
        ],
    ];
}
```

In the translation ymls you can add the title of the grouped like this:
```yml
en:
  App\Admins\MyAdmin:
    project: 'Project'
    grouped: 'Grouped'
```

## Reporting Issues
Please [create an issue](https://github.com/pixelpoems/silverstripe-grouped-tabs/issues) for any bugs you've found, or
features you're missing.


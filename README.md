
## About Solution Forest

[Solution Forest](https://solutionforest.com) Web development agency based in Hong Kong. We help customers to solve their problems. We Love Open Soruces. 

We have built a collection of best-in-class products:

- [VantagoAds](https://vantagoads.com): A self manage Ads Server, Simplify Your Advertising Strategy.
- [GatherPro.events](https://gatherpro.events): A Event Photos management tools, Streamline Your Event Photos.
- [Website CMS Management](https://filamentphp.com/plugins/solution-forest-cms-website): Website CMS Management - Filament CMS Plugin
- [Filaletter](https://filaletter.solutionforest.net): Filaletter - Filament Newsletter Plugin

# Filament Field Group

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solution-forest/filament-field-group.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-field-group)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/solutionforest/filament-field-group/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/solutionforest/filament-field-group/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/solutionforest/filament-field-group/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/solutionforest/filament-field-group/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/solution-forest/filament-field-group.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-field-group)


Filament Field Group is a powerful Laravel package that enhances Filament's form building capabilities. It allows you to easily group and organize form fields, improving the structure and readability of your forms. With this package, you can create collapsible sections, tabs, or custom layouts for your form fields, making complex forms more manageable and user-friendly.


## Installation

1. You can install the package via composer:
    ```bash
    composer require solution-forest/filament-field-group
    ```
2. Register the plugin in your Panel provider
   ```php
    use SolutionForest\FilamentFieldGroup\FilamentFieldGroupPlugin;

    class AdminPanelProvider extends PanelProvider
    {
        public function panel(Panel $panel): Panel
        {
            return $panel
                ->plugin(FilamentFieldGroupPlugin::make());
        }
    }
   ```
3. Then execute the following commands:
    ```bash
    php artisan filament-field-group:install
    ```

## Publish Config, View, Translation and Migration
You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-field-group-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-field-group-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-field-group-views"
```

This is the contents of the published config file:

```php
return [
    'enabled' => false,
    'models' => [
        'field' => \SolutionForest\FilamentFieldGroup\Models\Field::class,
        'field_group' => SolutionForest\FilamentFieldGroup\Models\FieldGroup::class,
    ],
    'table_names' => [
        'fields' => 'advanced_fields',
        'field_groups' => 'advanced_field_groups',
    ],
];
```

## Usage

1. Add `FilamentFieldGroupPlugin` to you panel.
2. Enable the Field Group resource by setting `enabled` to `true` in the config file:
```php

// config/filament-field-group.php
return [
    'enabled' => true,
    // ... other config options
];
```
Or enable the plugin on `FilamentFieldGroupPlugin`
```php
use SolutionForest\FilamentFieldGroup\FilamentFieldGroupPlugin;
 
$panel
    ->plugin(FilamentFieldGroupPlugin::make()->enablePlugin());
```
![Filament Field Group](https://github.com/solutionforest/filament-field-group/raw/main/docs-assets/images/initial-resource.png)

3. Create field groups and fields, for example:

   - Navigate to the Field Group resource in your Filament admin panel.
   - Create a new field group (e.g., "User Basic Info").
   - Add fields to the group (e.g., name, email, etc.).
![Create Field Group and Field](https://github.com/solutionforest/filament-field-group/raw/main/docs-assets/images/add-field-1.png)
![Create Field Group and Field](https://github.com/solutionforest/filament-field-group/raw/main/docs-assets/images/add-field-2.png)
![Create Field Group and Field](https://github.com/solutionforest/filament-field-group/raw/main/docs-assets/images/add-field-3.png)

4. Apply field groups to your form schema:
```php

use SolutionForest\FilamentFieldGroup\Facades\FilamentFieldGroup;

public static function form(Form $form): Form
{
    return $form
        ->columns(1)
        ->schema([
            FilamentFieldGroup::findFieldGroup('user_basic'),
            FilamentFieldGroup::findFieldGroup('user_detail'),
        ]);
}
```
![Apply Field Group](https://github.com/solutionforest/filament-field-group/raw/main/docs-assets/images/apply-field-group.png)
   
## Available Components

Currently, this package provides the following components:

- Text
- TextArea
- Email
- Password
- Number
- Url
- Select
- Toggle
- Radio
- File
- Image
- Color Picker
- DateTime Picker

More components can be added in the future. Feel free to submit a pull request if you have ideas for additional components!


## Advanced Usage
### Custom Resources
You can call `resources` on `FilamentFieldGroupPlugin` to add/replace original resource:
```php
use SolutionForest\FilamentFieldGroup\FilamentFieldGroupPlugin;
 
$panel
    ->plugin(FilamentFieldGroupPlugin::make()
        ->resources([
            // your resource
        ], override: true)
    );
```

### Custom Field Types

You can add your own custom field types by following these steps:

1. Create a field type class that extends `SolutionForest\FilamentFieldGroup\FieldTypes\Configs\FieldTypeBaseConfig`
2. Implement the required methods, particularly `getFormSchema()` which defines the form fields
3. Register your custom field type using one of the methods below:

```php
// Option 1: On Your Filament Panel

use SolutionForest\FilamentFieldGroup\FilamentFieldGroupPlugin;

$panel
    ->plugin(FilamentFieldGroupPlugin::make()
        ->fieldTypeConfigs([
            // your field type config
        ], override: true)
    );
```

```php
// Option 2: On Your AppServiceProvider

use SolutionForest\FilamentFieldGroup\Facades\FilamentFieldGroup;

public function boot(): void
{
    FilamentFieldGroup::fieldTypeConfigs([
        \Your\Custom\FieldType::class
    ], override: true);
}
```

To completely replace all default field types, set the `override` parameter to `true`.

#### Customizing Field Type Config Form

You can customize the `config` form for specific field types by adding your own custom options. This is useful when you need to extend the functionality of existing field types with additional **configuration parameters**.

```php
// In AppServiceProvider.php boot() method
use SolutionForest\FilamentFieldGroup\Facades\FilamentFieldGroup;

public function boot(): void
{
    FilamentFieldGroup::configureFieldTypeConfigFormUsing(
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Text::class,
        function ($field, array $schema) {
            return [
                ...$schema,
                // Your additional config form fields
                Toggle::make('datalist'),
                // More custom configuration options...
            ];
        }
    );
}
```

This allows you to modify the configuration form for field types while preserving all the default options.


### Custom Models

You can set custom models for field groups and fields in your `AppServiceProvider`:

```php
// In AppServiceProvider.php boot() method
use SolutionForest\FilamentFieldGroup\Facades\FilamentFieldGroup;

public function boot(): void
{
    FilamentFieldGroup::setFieldGroupModelClass(Your\Models\FieldGroup::class);
    FilamentFieldGroup::setFieldModelClass(Your\Models\Field::class);
}
```

### Field Type Mixins

You can extend field type functionality using the `mixin` method on `FieldTypeBaseConfig`. This allows you to reuse field configuration logic across different field types:

```php
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\FieldTypeBaseConfig;

class MyFieldTypeMixin
{
    public function addValidationRules()
    {
        return function (array $rules = []) {
            return array_merge($rules, ['required', 'string']);
        };
    }
    
    public function addHelperText()
    {
        return function () {
            return 'This is a helper text for all fields using this mixin';
        };
    }
}

// Apply the mixin to your field type
FieldTypeBaseConfig::mixin(new MyFieldTypeMixin());
```

You can also apply mixins to specific field type classes:

```php
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Text;

// Apply mixin only to Text fields
Text::mixin(new TextFieldSpecificMixin());
```

This approach helps maintain DRY code by centralizing common field configurations that can be shared across multiple field types.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

We welcome contributions to enhance this package. More components can potentially be added, so feel free to submit a pull request with your ideas or improvements.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [alan](https://github.com/solutionforest)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

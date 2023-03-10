# Scoro PHP

This an unofficial library for interacting with the Scoro Rest API.

### Install

Install with composer.

```shell
composer require coderjerk/scoro-php
 ```

### Examples

Instantiate the class
```php

use Coderjerk\ScoroPhp\ScoroPhp;

//add your company account id and api key, which you've stored safely in your env, for example.
$scoro = new ScoroPhp(
    $_ENV['SCORO_COMPANY_ACCOUNT_ID'],
    $_ENV['SCORO_API_KEY'],
);

```

The library provides a fluent interface, allowing you to build your query with method chaining

```php

$contacts = $scoro->module('contacts')->action('list')->call();

foreach ($contacts->data as $contact) {
   echo "<li>{$contact->name}</li>";
}

```

Add filters to your query

```php

$scoro->module('contacts')
    ->action('list')
    ->filter(['contact_type' => 'company'])
    ->call();

// you can dig in deep by nesting arrays depending on your data/module:

$filters = [
    'contact_type' => 'company',
    'means_of_contact' => [
        'website' => 'www.exampleclienta.co.uk'
    ]
];

$scoro->module('contacts')
    ->action('list')
    ->filter($filters)->call();

```

Use the `id()` method to target a single entity

```php
$scoro->module('contacts')
    ->action('view')
    ->id(36)
    ->call();

```

Use the `paginate()` method to set page and per page values

```php
$scoro->module('contacts')
    ->action('list')
    ->paginate(10, 2)
    ->call();

```

### Method Reference

All methods are optional bar module which must always be specified. In practice, this applies to action too in the vast majority of cases. End with `call()` to make the request.

Method | Accepts  | Type
---------|----------|--------
 `module($module)` | The targeted module name | String
 `action($action)` | One of: list, view, modify, delete | String
 `id($id)` | The id of the object you want to target, if available based on the module and action | Int
`filter($filters)` | [Filters](https://api.scoro.com/api/v2#filters) you wish to apply | Array
`request($requests)` | Items to specify in the request, varies from module to module | Array
`paginate($per_page, $page)` | Number of records per page (default 10, capped at 100) and page of results to retrieve|Int, Int
`lang($lang)` | Defaults to 'eng' | String
`call()` | Makes the request.


### Reference

Obviously you'll need a Scoro account to use the API. Read their API Reference for information about restrictions and rate limiting, and details of available endpoints.

[Scoro API Reference](https://api.scoro.com/api/v2)

# Scoro PHP

This an unofficial library for interacting with the Scoro Rest API.

### Install

Install with composer.

```shell
composer require coderjerk/scoro-php
 ```

### Example

Instantiate the class
```php

use Coderjerk\ScoroPhp\ScoroPhp;

//add your company account id and api key, which you've stored safely in your env, for example.
$scoro = new ScoroPhp(
    $_ENV['SCORO_COMPANY_ACCOUNT_ID'],
    $_ENV['SCORO_API_KEY'],
);

```

The library provides a fluent interface, allopwing you to build your query with method chaining.

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

Use the `id()` method to target a single entity.

```php
$scoro->module('contacts')
    ->action('view')
    ->id(36)
    ->call();

```

You can use the utility method if you don't like method chaining for some reason. Just pass the arguments directly in the correct order. See the inline documentation for more.

```php

use Coderjerk\ScoroPhp\ScoroPhp;

//add your company account id and api key, which you've stored safely in your env, for example.
$scoro = new ScoroPhp(
    $_ENV['SCORO_COMPANY_ACCOUNT_ID'],
    $_ENV['SCORO_API_KEY'],
);

// not the recommended way but you do you.

$contacts = $scoro->callWithArguments(
    'contacts', // the 'module' you want to hit
    'list' // the 'action'
);

// if you're sucessful you'll get an object in response.
// The good stuff is found in 'data'.
foreach ($contacts->data as $contact) {
    echo "<li>{$contact->name}</li>";
}

```


Argument | Description | Required | Type
---------|----------|---------|----------
 `$module` | the module accessed, for example 'contacts' | required | string
 `action` | what to do with the selected object, see the [Scoro API reference](https://api.scoro.com/api/v2) each module for a list of available action | optional | string
 `id` | the id of the object you want to target, if available based on the module and action | optional | string
 `filter` | [See Reference](https://api.scoro.com/api/v2#filters) | optional | array



### Reference

Obviously you'll need a Scoro account to use the API. Read their API Reference for information about restrictions and rate limiting, and details of available endpoints.

[Scoro API Reference](https://api.scoro.com/api/v2)

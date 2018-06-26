# Data-filter

Easily filter data with an encoded filter param in the uri.

## Requirements

This package requires PHP 5.6+.

## Installation

This package can be used in any PHP project or with any framework. The package is tested in PHP 5.6 and PHP 7.0.

You can install the package via composer:

```
composer require vdhicts/data-filter
```

## Usage

### Filter Field

Creating field is based on a key and a value:

```php
$fieldKey = 'manufacturer';
$fieldValue = 1;

$field = new Field($fieldKey, $fieldValue);
```

A field has the ability to accept, reject or see the value as part of a range with a third optional parameter. These 
parameters are constants of the field `APPROVAL_ACCEPT`, `APPROVAL_REJECT`, `APPROVAL_START_OF_RANGE`, 
`APPROVAL_END_OF_RANGE`, `APPROVAL_IN`, `APPROVAL_NOT_IN`, `APPROVAL_LIKE` and `APPROVAL_ILIKE` (which can only be used 
if your Database supports it, like Postgres).

### Filter Group

The field is a member of a group. The group has a conjunction, which are constants of the group called 
`CONJUNCTION_AND` and `CONJUCTION_OR`.

```php
$group = new Group('manufacturers', $field, Group::CONJUNCTION_OR);
```

One or more groups are provided to the filter:

```php
$filter = new Filter([$group]);
```

### Order

The sort order can be defined by `OrderField` objects:

```php
$orderField = new Orderfield('myField', 'ASC');
```

These objects are added to the order:

```php
$order = new Order([$orderField2]);
```

### Pagination

The pagination is handled by the `Pagination` object:

```php
$limit = 50;
$offset = 10;
$pagination = new Pagination($limit, $offset);
```

The remove the limit, use the `NO_LIMIT` constant from the `Pagination` class. By default no limit is used and the 
offset is zero.

### Manager

The manager can encode and decode the filter so it can be used in the url or session. The actual encoding or decoding 
is performed by a `Codec` which implements the `Codec` contract. By default a `Base64` codec is provided.

```php
$manager = new Manager(new Base64());
$encodedFilter = $manager->encode($filter);
```

The manager can decode the filter and will return a new filter instance:

```php
$decodedFilter = $manager->decode($encodedFilter);
```

A group can be retrieved by it's name from the filter:

```php
$decodedFilter->getGroup('manufacturers');
```

Which will return a `Group` object.

Fields can also be retrieved by their key from the group:

```php
$group->getFields('manufacturer');
```

Which will return an array of groups.

### Adapter

A query builder is provided to easily query your database with the filter configuration for the illuminate query 
builder:
 
```php
$filterAdapter = new QueryBuilder();

$queryBuilder = $filterAdapter->getFilterQuery($queryBuilder, $decodedFilter);
return $queryBuilder->get();
```

You are free to implement your own adapter, as long as it implements the `FilterAdapter` contract.

## Tests

Full code coverage unit tests are available in the tests folder. Run via phpunit:

`vendor\bin\phpunit` 

By default a coverage report will be generated in the build/coverage folder.

## Contribution

Any contribution is welcome, but it should be fully tested, meet the PSR-2 standard and please create one pull request 
per feature. In exchange you will be credited as contributor on this page.

## Security

If you discover any security related issues in this or other packages of Vdhicts, please email info@vdhicts.nl instead
of using the issue tracker.

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## About vdhicts

[Van der Heiden ICT services](https://www.vdhicts.nl) is the name of my personal company for which I work as
freelancer. Van der Heiden ICT services develops and implements IT solutions for businesses and educational
institutions.

# Data-filter

Easily filter data with an encoded filter param in the uri.

## Requirements

This package requires PHP 5.6+.

## Installation

This package can be used in any PHP project or with any framework. The packages is tested in PHP 5.6 and PHP 7.0.

You can install the package via composer:

```
composer require vdhicts/data-filter
```

## Usage

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

The field is a member of a group. The group has a conjunction, which are constants of the group called 
`CONJUNCTION_AND` and `CONJUCTION_OR`.

```php
$group = new Group('manufacturers', $field, Group::CONJUNCTION_OR);
```

One or more groups are provided to the filter:

```php
$filter = new Filter([$group]);
```

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

A query builder is provided to easily query your database with the filter configuration for the illuminate query 
builder:
 
```php
$filterAdapter = new QueryBuilder();

$queryBuilder = $filterAdapter->getFilterQuery($queryBuilder, $decodedFilter);
return $queryBuilder->get();
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

## Tests

Full code coverage unit tests are available in the `tests` folder. Run via phpunit:

`vendor\bin\phpunit tests`

Or if you are interested in the (html) coverage report:

`vendor\bin\phpunit tests --coverage-html report --whitelist src`

## Contribution

Any contribution is welcome, but it should be fully tested, meet the PSR-2 standard and please create one pull request 
per feature. In exchange you will be credited as contributor on this page.

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

# Germania KG · UserRoles

This package is distilled from legacy code. You certainly will not want to use this your production code.

[![Packagist](https://img.shields.io/packagist/v/germania-kg/user-roles.svg?style=flat)](https://packagist.org/packages/germania-kg/user-roles)
[![PHP version](https://img.shields.io/packagist/php-v/germania-kg/user-roles.svg)](https://packagist.org/packages/germania-kg/user-roles)
[![Build Status](https://img.shields.io/travis/GermaniaKG/UserRoles.svg?label=Travis%20CI)](https://travis-ci.org/GermaniaKG/UserRoles)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GermaniaKG/UserRoles/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/UserRoles/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/GermaniaKG/UserRoles/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/UserRoles/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/GermaniaKG/UserRoles/badges/build.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/UserRoles/build-status/master)



## Installation

Setup MySQL database with table creation listing in  `sql/users_roles.sql.txt`. Use Composer for PHP:

```bash
$ composer require germania-kg/user-roles
```



## Assign a user ID to a single role ID:



```php
<?php
use Germania\UserRoles\PdoAssignUserToRole;

$pdo    = new PDO( ... );
$logger = new Monolog();
// Default, thus optional
$table  = 'users_roles_mm';

$assigner = new PdoAssignUserToRole( $pdo, $logger, $table);

$user_id = 42;
$assigner( $user_id, 1);   // e.g. Admins
$assigner( $user_id, 2);   // e.g. Co-workers
$assigner( $user_id, 10);  // e.g. Sales people
```


## Retrieve user's role IDs

Retrieve an array containing role IDs for the given user.

```php
<?php
use Germania\UserRoles\PdoUserRoles;

$pdo     = new PDO( ... );
// Default, thus optional
$table   = 'users_roles_mm';

$roles_finder = new PdoUserRoles( $pdo, $table);

$user_id = 42;
$roles_array = $roles_finder( $user_id );

```

## Issues

- *user_id* column name in SQL still is *client_id*. This is legacy and subject to change in upcoming major versions. Discuss at [issue #1][i1].

Also see [full issues list.][i0]

[i0]: https://github.com/GermaniaKG/UserRoles/issues
[i1]: https://github.com/GermaniaKG/UserRoles/issues/1

## Development

```bash
$ git clone https://github.com/GermaniaKG/UserRoles.git
$ cd UserRoles
$ composer install
```

## Unit tests

Either copy `phpunit.xml.dist` to `phpunit.xml` and adapt to your needs, or leave as is. Run [PhpUnit](https://phpunit.de/) test or composer scripts like this:

```bash
$ composer test
# or
$ vendor/bin/phpunit
```

wk2014
======

Wk2014 is a handy package for retrieving world cup data from the football.db database.

[![Build Status](https://api.travis-ci.org/websoftwares/wk2014.png)](https://travis-ci.org/websoftwares/wk2014)
[![Coverage Status](https://img.shields.io/coveralls/websoftwares/wk2014.svg)](https://coveralls.io/r/websoftwares/wk2014?branch=master)

## Installing via Composer (recommended)

Install composer in your project:
```
curl -s http://getcomposer.org/installer | php
```

Create a composer.json file in your project root:
```
{
    "require": {
        "websoftwares/wk2014": "dev-master"
    }
}
```

Install via composer
```
php composer.phar install
```

## getTeamMatches($code)
Retrieve matches for a team by fifa [FIFA country code](http://en.wikipedia.org/wiki/List_of_FIFA_country_codes)
```php
use Websoftwares\Wk2014\Teams, Monolog\Logger;

$logger = new Logger('Wk2014');

// getTeamMatches PHP 5.4+ syntax
$teamMatches = (new Teams($logger))->getTeamMatches("NED");

// getTeamMatches PHP 5.4+ syntax another language
$teamMatches = (new Teams($logger), "NL")->getTeamMatches("NED");

```

## getGroup($id)
Retrieve a list of teams in the group from the database

```php
use Websoftwares\Wk2014\Groups, Monolog\Logger;

$logger = new Logger('Wk2014');

// getGroups PHP 5.4+ syntax
$group = (new Groups($logger))->getGroups(2);

// getGroups PHP 5.4+ syntax another language
$group = (new Groups($logger), "NL")->getGroups(2);
```

## Translations
Teams contending at the FIFA Worldcup 2014 Brazil in the following language(s)
- NL

## Todo
Add more methods for the dataset, pherhaps extend the events not just world cup.

## Logger
Any logger library that implements the [PSR-3](https://github.com/php-fig/log) _LoggerInterface_ should work,
just create your Logger object and inject it into the `Wk2014 Classes` constructors.
For example the excellent logging library [Monolog](https://github.com/Seldaek/monolog).

## Testing
In the tests folder u can find several tests.

## License
The [MIT](http://opensource.org/licenses/MIT "MIT") License (MIT).

## Acknowledgement
@openfootball team members for building the football.db
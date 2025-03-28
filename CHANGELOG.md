Changelog
=========

7.0.0 (2025-03-20)
------------------

- Minimum PHP version increased to 8.4
- Minimum Laravel version increased to 12


6.3.0 (2025-03-12)
------------------

- Added support for Laravel 11


6.2.0 (2023-02-20)
------------------

- Added support for Laravel 10


6.1.0 (2022-02-12)
------------------

- Added support for Laravel 9


6.0.1 (2021-10-22)
------------------

- Fix default to bigInteger


6.0.0 (2021-10-21)
------------------

- Removed support of PHP 7 and earlier
- Removed support of Laravel 7 and earlier
- By default addAuthorableColumns() migration helper now create bigInteger columns instead of integer


5.1.0 (2020-11-01)
------------------

- More controls on addAuthorableColumns() migration helper


5.0.0 (2020-10-01)
------------------

- Moved events registration from service provider to AuthorableTrait for performances
- Dropped Authorable interface since it is no longer necessary
- Add migration helpers


4.2.0 (2020-09-24)
------------------

- Added support for Laravel 8


4.1.0 (2020-03-05)
------------------

- Added support for Laravel 7


4.0.0 (2019-12-31)
------------------

- Added support for Laravel 6
- Dropped support for Laravel 5.7 and older


3.2.1 (2019-10-31)
------------------

- Retrieve author even if soft deleted


3.2.0 (2019-03-08)
------------------

- Added support for Laravel 5.8


3.1.1 (2019-01-22)
------------------

- Added missing composer extra section for Laravel


3.1.0 (2018-05-24)
------------------

- Support for Laravel 5.5.x ; 5.6.x and 5.7.x
- Added new configuration entry to customize the authentication Guard to use


3.0.1 (2018-05-24)
------------------

- Added missing mergeConfigFrom call in service provider


3.0.0 (2017-08-31)
------------------

- Fix wildcard event handler signatures for Laravel 5.4.x


2.1.0 (2017-05-15)
------------------

- Support for Laravel 5.4.x


2.0.0 (2016-12-07)
------------------

- Branche 2.x for Laravel 5.2.x and 5.3.x
- Added config file with default partameters


1.0.4 (2016-12-07)
------------------

- Typo in composer.json


1.0.3 (2016-12-07)
------------------

- Branche 1.x for Laravel 5.0.x and 5.1.x


1.0.2 (2016-11-02)
------------------

- Moved to Github


1.0.1 (2016-04-05)
------------------

- Support Laravel 5.0


1.0.0 (2016-03-24)
------------------

- First release.

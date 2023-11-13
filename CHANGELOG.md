# Changelog

All notable changes to this project will be documented in this file,
in reverse chronological order by release.

## [v2.2.1](https://github.com/zaphyr-org/utils/compare/2.2.0...2.2.1) [2023-11-13]

### New:
* Added `.vscode/` to .gitignore file

### Changed:
* Refactored Form and Template classes
* Improved unit tests and moved tests to "Unit" directory

### Removed:
* Removed phpstan-phpunit from composer require-dev

## [v2.2.0](https://github.com/zaphyr-org/utils/compare/2.1.0...2.2.0) [2023-10-08]

### New:
* Added `serialize()` and `unserialize()` to File class

### Changed:
* Renamed `unit` to `phpunit` in composer.json scripts section
* Renamed phpunit.xml.dist to phpunit.xml

### Removed:
* Removed "/tests" directory from phpstan paths

### Fixed:
* Removed .dist from phpunit.xml in .gitattributes export-ignore

## [v2.1.0](https://github.com/zaphyr-org/utils/compare/2.0.0...2.1.0) [2023-06-26]

### New:
* Added Template.php

### Fixed:
* Fixed PHP 8.1 deprecation warnings

## [v2.0.0](https://github.com/zaphyr-org/utils/compare/1.0.1...2.0.0) [2023-04-10]

### New:
* First stable release version

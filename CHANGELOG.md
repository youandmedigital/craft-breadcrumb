# Breadcrumb Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 1.0.3 - 2019-03-06
### Fixed
- homeUrl only working for the first URL segment
- baseUrl not respecting the current site [#4](https://github.com/youandmedigital/craft-breadcrumb/issues/4)

### Changed
- Check for an Entry or Category element when applying a custom title
- Readme improvements

### Added
- Added documentationUrl to extra in composer.json to fix documentation link not showing

## 1.0.2 - 2019-02-28
### Changed
- Readme improvements
- Improved how custom titles are handled in category elements

### Removed
- Removed check for tag element

## 1.0.1 - 2019-02-28
### Changed
- Docs link in composer.json

## 1.0.0 - 2019-02-27
### Added
- Improved documentation
- Added the ability to limit results in the Breadcrumb array

## 0.0.1 - 2019-02-25
### Added
- Initial release

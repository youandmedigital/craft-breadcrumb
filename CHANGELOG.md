# Breadcrumb Changelog

## 2.0.0 - 2022-10-03
### Changed
- Now requires Craft `4.0.0+`
- Now requires PHP `8.0.2+`

### Removed
- Dead element variable

## 1.1.1 - 2019-11-8
### Added
- Better check if element has a traditional title or not

### Changed
- isElement now uses instanceof to check for the element interface

### Fixed
- Some code inconsistencies

### Removed
- Dead element variable

## 1.1.0 - 2019-11-07
> {warning} Crumb titles are now generated from the following fields in order of priority 1) customFieldHandle, 2) title, 3) URL segment  

> {warning} Crumbs generated from a URL segment will no longer appear capitalized. Please use CSS text-transform if you want to capitalize crumb titles

### Changed
- customFieldHandle setting now applies to all crumbs in the breadcrumb array, not just the last
- Crumbs are now generated from the customFieldHandle setting which will fallback to title if customFieldHandle setting is empty. If a crumb in the breadcrumb is not an element the crumb title will be generated from the URL segment

### Fixed
- skipUrlSegment now works more consistently

### Removed
- Automatic capitalization of crumb titles that are generated from a URL segment [#6](https://github.com/youandmedigital/craft-breadcrumb/issues/6)

## 1.0.4 - 2019-03-15
### Added
- lastSegmentTitle which allows you to pass in a string to customise the title in the last segment of the breadcrumb

### Changed
- how defaults are set
- homeUrl to customBaseUrl which reflects the setting better. homeUrl is still supported
- Simplified null coalescing operators

## 1.0.3 - 2019-03-06
### Added
- Added documentationUrl to extra in composer.json to fix documentation link not showing

### Changed
- Check for an Entry or Category element when applying a custom title
- Readme improvements

### Fixed
- homeUrl only working for the first URL segment
- baseUrl not respecting the current site [#4](https://github.com/youandmedigital/craft-breadcrumb/issues/4)

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

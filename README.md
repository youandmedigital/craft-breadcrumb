<p align="center">
    <img src="https://github.com/youandmedigital/craft-breadcrumb/blob/craft-4/src/icon.svg" alt="Craft Breadcrumb" width="150"/>
</p>

# Breadcrumb for Craft CMS

Generate a simple breadcrumb.

## Requirements

This plugin requires Craft CMS 4 or later.

<p align="center">
    <img src="https://raw.githubusercontent.com/youandmedigital/craft-breadcrumb/craft-4/src/resources/plugin-banner.jpg" alt="Breadcrumb from URL" />
</p>

## Installation

To install the plugin, search for "Breadcrumb" in the Craft Plugin Store, or install manually using composer.

```
composer require youandmedigital/breadcrumb
```

## Overview

This plugin will generate a simple breadcrumb array that you can style via Twig. It will generate crumb titles from the customFieldHandle setting if set, falling back to the title field. If none of these fields are present, it will generate the crumb title from the URL segment.

Breadcrumb works across different element types and is multisite friendly. It can even be used to generate `BreadcrumbList` [schema](https://developers.google.com/search/docs/data-types/breadcrumb#definitions).

## Example

Breadcrumb generates an array like this:

```array
array (size=4)
  0 =>
    array (size=3)
      'title' => string 'Home' (length=4)
      'url' => string 'https://mysite.local' (length=18)
      'position' => int 1
  1 =>
    array (size=3)
      'title' => string 'Posts' (length=5)
      'url' => string 'https://mysite.local/posts' (length=24)
      'position' => int 2
  2 =>
    array (size=3)
      'title' => string 'Categories' (length=10)
      'url' => string 'https://mysite.local/posts/categories' (length=35)
      'position' => int 3
  3 =>
    array (size=3)
      'title' => string 'Example Category' (length=11)
      'url' => string 'https://mysite.local/posts/categories/example-category' (length=52)
      'position' => int 4
```

Use Twig to define the presentation and apply additional logic. Use whatever markup that suits your project best. Here's a basic example with no settings applied:

```twig
{% set breadcrumb = craft.breadcrumb.config %}

{% if breadcrumb %}
<div class="c-breadcrumb">
    <ol class="c-breadcrumb__items">
        {% for crumb in breadcrumb  %}
            {% if loop.last %}
            <li class="c-breadcrumb__item">
                <span>{{ crumb.title }}</span>
            </li>
            {% else %}
            <li class="c-breadcrumb__item">
                <a class="c-breadcrumb__link" href="{{ crumb.url }}">
                    <span>{{ crumb.title }}</span>
                </a>
            </li>
            {% endif %}
        {% endfor %}
    </ol>
</div>
{% endif %}
```
## Settings

Breadcrumb has the following settings available:

**homeTitle**
`(string, optional, default 'Home')`
Customise the title in the first segment of the breadcrumb.

**customBaseUrl**
`(string, optional, default '@baseUrl')`
Set a custom base URL for each crumb in the Breadcrumb array. Use a fully qualified URL without the trailing slash.

**customFieldHandle**
`(string, optional, default 'null')`
Specify a custom field handle to generate each crumb title. Requires the setting customFieldHandleEntryId to work.

**customFieldHandleEntryId**
`(int, optional, default '0')`
Required for customFieldHandle.

**lastSegmentTitle**
`(string, optional, default 'null')`
Customise the last crumb title in the Breadcrumb array. Useful when using custom routing.

**skipUrlSegment**
`(int, optional, default 'null')`
Skip a level or segment from the Breadcrumb array. For example, if you had the following URL `https://mysite.local/posts/categories/example-category` and you entered `3` as the value, it would remove `categories` from the array.

**limit**
`(int, optional, default 'null')`
Limit the amount of crumbs returned in the Breadcrumb array.

Example setup with settings applied:

```twig
{# If entry is empty, try category, tag and finally return null #}
{% set element = entry ?? category ?? tag ?? null %}

{# Breadcrumb settings array #}
{% set settings =
    {
        homeTitle: 'My Website',
        customBaseUrl: 'https://example.com/123',
        customFieldHandleEntryId: element.id,
        customFieldHandle: 'myCustomField',
        lastSegmentTitle: element.customMenuTitle ?? element.title,
        skipUrlSegment: 2,
        limit: 3
    }
%}

{# The settings array above is passed into the Breadcrumb config below #}
{% set breadcrumb = craft.breadcrumb.config(settings) %}

{% if breadcrumb %}
<div class="c-breadcrumb">
    <ol class="c-breadcrumb__items">
        {% for crumb in breadcrumb  %}
            {% if loop.last %}
            <li class="c-breadcrumb__item">
                <span>{{ crumb.title }}</span>
            </li>
            {% else %}
            <li class="c-breadcrumb__item">
                <a class="c-breadcrumb__link" href="{{ crumb.url }}">
                    <span>{{ crumb.title }}</span>
                </a>
            </li>
            {% endif %}
        {% endfor %}
    </ol>
</div>
{% endif %}
```

## Roadmap

PR & FR welcome!

Brought to you by [You & Me Digital](https://youandme.digital)

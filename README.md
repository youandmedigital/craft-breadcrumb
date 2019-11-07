<p align="center">
    <img src="https://github.com/youandmedigital/craft-breadcrumb/blob/master/src/icon.svg" alt="Craft Breadcrumb" width="150"/>
</p>

# Breadcrumb for Craft 3.1

Generate a simple breadcrumb from a URL.

## Requirements

This plugin requires Craft CMS 3.1 or later.

<p align="center">
    <img src="https://raw.githubusercontent.com/youandmedigital/craft-breadcrumb/master/src/resources/plugin-banner.jpg" alt="Breadcrumb from URL" />
</p>

## Installation

To install the plugin, search for "Breadcrumb" in the Craft Plugin Store, or install manually using composer.

```
composer require youandmedigital/breadcrumb
```

## Breadcrumb Overview

This plugin will generate a simple breadcrumb array that you can style via Twig. It will generate crumb titles from customFieldHandle if set, falling back to the title field. If none of these fields are present, it will generate the crumb title from the slug field.

Breadcrumb works across different element types and is multisite friendly. It can even be used to generate `BreadcrumbList` schema.

Example Breadcrumb output:

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

Use Twig to define the presentation and apply additional logic. Here's a basic example with no settings applied:

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
## Configuring Breadcrumb

Breadcrumb has the following settings available:

**homeTitle**
`(string, optional, default 'Home')`

Customise the title in the first segment of the breadcrumb.

**customBaseUrl**
`(string, optional, default '@baseUrl')`

Set a custom base URL for each crumb in the Breadcrumb array. Use a fully qualified URL without the trailing slash.

**skipUrlSegment**
`(int, optional, default 'null')`

Skip a level or segment from the Breadcrumb array. For example, if you had the following URL `https://mysite.local/posts/categories/example-category` and you entered `3` as the value, it would remove `categories` from the array.

**customFieldHandle**
`(string, optional, default 'null')`

Specify a custom field handle to generate each crumb title. Requires the setting customFieldHandleEntryId to work.

**customFieldHandleEntryId**
`(int, optional, default '0')`

Required for customFieldHandle.

**lastSegmentTitle**
`(string, optional, default 'null')`

Customise the last crumb title in the Breadcrumb array. Useful when using custom routing.

**limit**
`(int, optional, default 'null')`

Limit the amount of crumbs returned in the Breadcrumb array.

Example setting configuration:

```twig
{# If entry is empty, try category, tag and finally return null #}
{% set element = entry ?? category ?? tag ?? null %}

{# Breadcrumb settings array #}
{% set settings =
    {
        homeTitle: 'My Website',
        skipUrlSegment: 2,
        customBaseUrl: 'https://example.com/123',
        customFieldHandleEntryId: element.id,
        customFieldHandle: 'myCustomField',
        lastSegmentTitle: element.customMenuTitle ?? element.title,
        limit: '3'
    }
%}

{# The settings array above is passed into the Breadcrumb config below #}
{% set breadcrumb = craft.breadcrumb.config(settings) %}
```

## Breadcrumb Roadmap

PR & FR welcome!

Brought to you by [You & Me Digital](https://youandme.digital)

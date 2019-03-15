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

## Breadcrumb might not be right for your project...

- If you don't have templates defined for each URL segment

- If your URLs don't make sense to a human

- If you want to customise each title in the breadcrumb

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require youandmedigital/breadcrumb

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Breadcrumb.

## Breadcrumb Overview

Generate a simple breadcrumb based on segments in your URL. It's perfect for websites that have descriptive and meaningful URLs.

If your website URL looked like this:
```
https://mysite.local/posts/categories/example-category
```

Breadcrumb would generate the following array:
```
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

With this array, you can now use Twig to define the look and apply additional logic. Here's a basic example:

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

This example uses the [Twig loop variable](https://twig.symfony.com/doc/2.x/tags/for.html#the-loop-variable) to set the last item in the crumb.

## Configuring Breadcrumb

Breadcrumb has the following settings available:

- **homeTitle** `(string, optional, default 'Home')`: Customise the title in the first segment of the breadcrumb.

- **customBaseUrl** `(string, optional, default '@baseUrl')`: Set a custom base URL.

- **skipUrlSegment** `(int, optional, default 'null')`: Remove a segment from the Breadcrumb array. For example, if you have the URL `https://mysite.local/posts/categories/example-category` and wanted to remove `categories` from the array, you would enter `3` as the value.

- **customFieldHandle** `(string, optional, default 'null')`: Specify a field to customise the title in the last segment of the breadcrumb. Requires the setting customFieldHandleEntryId to work.

- **customFieldHandleEntryId** `(int, optional, default '0')`: Required for customFieldHandle.

- **lastSegmentTitle** `(string, optional, default 'null')`: Customise the title in the last segment of the breadcrumb. Use this setting in favour of customFieldHandleEntryId and customFieldHandle. lastSegmentTitle will take priority over customFieldHandle.

- **limit** `(int, optional, default 'null')`: Limit the amount of crumbs returned in the Breadcrumb array.

Example setting configuration:

```twig
{# If entry variable is empty, try category, tag and finally return null #}
{# This works with customFieldHandleEntryId and customFieldHandle #}
{% set entry = entry ?? category ?? tag ?? null %}

{# Breadcrumb settings array #}
{% set settings =
    {
        homeTitle: 'My Website',
        skipUrlSegment: 2,
        customBaseUrl: 'https://example.com/123',
        customFieldHandleEntryId: entry.id ?? null,
        customFieldHandle: 'myCustomField',
        limit: '3'
    }
%}

{# The settings array above is passed into the Breadcrumb config below #}
{% set breadcrumb = craft.breadcrumb.config(settings) %}
```

## Breadcrumb Roadmap

Some things to do, and ideas for potential features:

* Use Yii array helper where possible

PR & FR welcome!

Brought to you by [You & Me Digital](https://youandme.digital)

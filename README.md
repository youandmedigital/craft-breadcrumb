# Breadcrumb plugin for Craft CMS 3.1

Generate a simple breadcrumb based on the segments in your URL

## Requirements

This plugin requires Craft CMS 3.1 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require youandmedigital/breadcrumb

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Breadcrumb.

## Breadcrumb Overview

Generate a simple breadcrumb based on the segments in your URL. It is perfect for websites that have descriptive and meaningful URL's.

No need to setup a breadcrumb for sections and another for categories or even tags.

If your website URL looked like this:
```
https://mysite.local/posts/categories/example-category
```

Breadcrumb would automatically generate the following array:
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

```
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

```
{# If entry variable is empty, try category, tag and finally return null #}
{# This works with customFieldHandleEntryId and customFieldHandle #}
{% set entry = entry ?? category ?? tag ?? null %}

{# Breadcrumb settings array #}
{% set settings =
    {
        homeTitle: 'Home',
        homeUrl: 'https://example.com',
        skipUrlSegment: 1,
        customFieldHandleEntryId: entry.id,
        customFieldHandle: 'myCustomField',
        limit: '3'
    }
%}

{# Settings array passed into the Breadcrumb config #}
{% set breadcrumb = craft.breadcrumb.config(settings) %}
```
- **homeTitle** `(string, optional, default 'Home')`: Customise the title of the first item in the breadcrumb

- **homeUrl** `(string, optional, default '@baseUrl')`: Set a custom URL for the first item in the breadcrumb

- **skipUrlSegment** `(int, optional, default 'null')`: Remove a segment from the Breadcrumb array. For example, if you have the URL `https://mysite.local/posts/categories/example-category` and wanted to remove `categories` from the array, you would enter `3` as the value.

- **customFieldHandleEntryId** `(int, optional, default '0')`: Required for customFieldHandle. Nothing to customise.

- **customFieldHandle** `(string, optional, default 'null')`: Specify a field that contains a custom title. This only works for the last item in the breadcrumb array. Requires customFieldHandleEntryId to work.

- **limit** `(int, optional, default 'null')`: Limit the amount of results returned in the Breadcrumb array.

## Is Breadcrumb right for me?

If you have a URL like `https://mysite.local/posts/categories/example-category`, Breadcrumb will generate an array based on each segment in the URL. This means if you don't have a template or redirect setup for `https://mysite.local/posts/categories` the link will return a 404.

If you have a url that looks like `https://mysite.local/c/12/random/post-title`, Breadcrumb is not for you.

If you need to pull in a custom field to generate each title, Breadcrumb is not for you. Titles are generated from the URL. You can only customise the last url segment.

If you have a multilingual site setup, Breadcrumb will add the language segment to the crumb. This can be fixed by working with `skipUrlSegment` and rebuilding the `homeTitle` and `homeUrl`.


## Breadcrumb Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [You & Me Digital](https://youandme.digital)

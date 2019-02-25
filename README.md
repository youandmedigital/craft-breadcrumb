# Breadcrumb plugin for Craft CMS 3.x

tbc

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require youandmedigital/breadcrumb

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Breadcrumb.

## Breadcrumb Overview

-Insert text here-

## Configuring Breadcrumb

```
{% set settings =
    {
        homeTitle: 'Home',
        homeUrl: 'https://google.com',
        skipUrl: 1
    }
%}
{% set breadcrumb = craft.breadcrumb.config(settings) %}
```
```
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

## Using Breadcrumb

-Insert text here-

## Breadcrumb Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [You & Me Digital](https://youandme.digital)

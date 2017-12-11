# Shortcode Module

[![Build Status](https://travis-ci.org/wpfulcrum/shortcode.svg?branch=develop)](https://travis-ci.org/wpfulcrum/shortcode) 
[![Latest Stable Version](https://poser.pugx.org/wpfulcrum/shortcode/v/stable)](https://packagist.org/packages/wpfulcrum/shortcode) 
[![License](https://poser.pugx.org/wpfulcrum/shortcode/license)](https://packagist.org/packages/wpfulcrum/shortcode)

The Fulcrum Custom Shortcode Module makes your job easier for adding shortcodes to your project. Pass it a configuration, build your view file, and it handles the rest for you.

## Features

- Registration is handled for you.
- Merges the user-defined atts with the defaults you specify, i.e. handles `shortcode_atts` for you.
- Renders the view file you specify in the configuration.
- Use the built-in `Shortcode` class or specify a custom one within your configuration file.
- Stores in Fulcrum's Container - when added, automatically stores it in the Container for global usage.

## Installation

The best way to use this component is through Composer:

```
composer require wpfulcrum/shortcode
```

## Dependencies

This module requires:
 
- at least PHP 5.6
- WordPress 4.8+

## Configuring a Shortcode

This module, as with all Fulcrum modules, is configuration driven as part of the ModularConfig design pattern.  In your theme/plugin's configuration folder, you will want to create a configuration file.  Here is the basic structure of that file:

```php
<?php

return [
    /**
     * Defines whether the shortcode should autoload when registering with Fulcrum.
     *
     * Default is true.
     */
    'autoload'  => true,
    
    /**
     * If you'd like to build your own shortcode class, specify the class name here, such as:
     *
     * Fulcrum\Custom\Shortcode\Shortcode
     *
     * By default, it will use the built-in Shortcode class.
     */
    'classname' => '',

    'config'    => [
        /**
         * Specify the name of the shortcode.  This is the "tag" which is used in the content as: [foo].
         */
        'shortcode' => 'foo',

        /**
         * Set this parameter to `true` when no view file is needed for this shortcode.
         */
        'noView' => false,

        /**
         * Specify the absolute path to this shortcode's view file.
         * The view file contains the HTML that is built for this shortcode.
         */
        'view'      => __DIR__ . '/views/foo.php',

        /**
         * Specify the default attributes for this shortcode.
         */
        'defaults'  => [
            'class' => 'foobar',
        ],
    ],
];
```

## The View File

Shortcodes create HTML that is returned back for inclusion into the content that sent out to the browser.  Create a view file for your shortcode.

### Example: View File

```php
<p class="<?php echo $this->getClass(); ?>"><?php echo $this->content; ?></p>
```

### Properties Available

The following properties are available for you to use within your view file:

- `$this->attributes` - Array of attributes after merging the user-defined with the defaults using `shortcode_atts`.
- `$this->content` - The content passed into the shortcode, e.g. `[foo]This is the content[/foo]`.

### Methods Available

Some common shortcode attributes are `id` and `class` attributes.  You can use the following methods to get either of these for your view:

- `$this->getId()` which escapes and returns ` id="the-id"`.
- `$this->getClass()` which escapes and returns the class attribute, e.g. `foobar`.  You can pass a `true` to it to add a space in front of the class attribute, e.g. `$this->getClass()` returns ` foobar`.

## Making It Work

There are 2 ways to utilize this module:

1. With the full [Fulcrum plugin](https://github.com/wpfulcrum/fulcrum).
2. Or on its own without Fulcrum.

### With Fulcrum

In Fulcrum, your plugin is an Add-on.  In your plugin's configuration file, you will have a parameter for the `serviceProviders`, where you list each of the service providers you want to use.  In this case, you'll use the `provider.post_type`.  

For example, using our Book configuration above, this would be the configuration:

```
	'serviceProviders' => [

		/****************************
		 * Custom Post Types
		 ****************************/
		'foo.shortcode' => array(
			'provider' => 'provider.shortcode', // this is the service provider to be used.
			'config'   => FOO_PLUGIN_DIR . 'config/shortcode/foo.php', // path to the shortcode's configuration file.
		),
	],
```

### Without Fulcrum

Without Fulcrum, you'll need to instantiate each of the dependencies and `Shortcode`.  For example, you would do:

```
new Shortcode(
    ConfigFactory::create(FOO_PLUGIN_DIR . 'config/shortcode/foo.php'), // path to the shortcode's configuration file.
);
```

## Contributing

All feedback, bug reports, and pull requests are welcome.
# Locale Chooser for PHP
This is a simple class to detect the locale that the user preffers.

## Installation
The easiest way to install this is through composer, inside your composer.json require block add

    "arosemena/localechooser": "1.0.0"

and then do `composer update`, otherwise you could grab the class itself and autoload it with the method of your choosing.

## Usage

First you need an instance of the LocaleChooser class, the constructor takes 3 parameters, first an array of the available language, `['en', 'es', 'fr']` for example, the second parameter is a string of the default language in case nothing can be matched, the third parameter is the name of the cookie that contains the language that overrides all the normal priority.

```php
    $chooser = new Arosemena\LanguageChooser\LanguageChooser(['en', 'es'], 'en', 'language');
```

After the class has been instanciated do `$chooser->obtain()` to get the appropiate locale.

## Examples

```php
    $chooser = new Arosemena\LanguageChooser\LanguageChooser(['en', 'es', 'fr'], 'es', 'language');
    // if the browser says that the user prefers french (fr)
    $chooser->obtain(); // returns 'fr'
    // if the browser says that the user prefers german (de)
    $chooser->obtain(); // returns 'es' because it is the default language and german isn't supported
    // if the browser says that the user prefers spanish (es) and sends a cookie named language with the value 'fr'
    $chooser->obtain(); // returns 'fr' because the cookie overrides the browser preferred language
```

## How does it work?
The class will read the `$_SERVER['HTTP_ACCEPT_LANGUAGE']` variable which is a header sent by most modern browsers and it will be parsed and evaluated against the available languages to determine the most appropiate one.
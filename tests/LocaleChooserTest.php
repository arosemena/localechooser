<?php

class LocaleChooserTest extends PHPUnit_Framework_TestCase
{
  public function testLocaleWithSameDefault()
  {
    // Simulates a browser header that prefers english
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en-US,en;q=0.8,es;q=0.6';

    $locale = new Arosemena\LocaleChooser\LocaleChooser(['en', 'es', 'fr'], 'en', 'nothing');
    $this->assertEquals('en', $locale->obtain());
  }

  public function testLocaleWithoutSameDefault()
  {
    // Simulates a browser header that prefers english
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en-US,en;q=0.8,es;q=0.6';

    $locale = new Arosemena\LocaleChooser\LocaleChooser(['en', 'es', 'fr'], 'fr', 'nothing');
    $this->assertEquals('en', $locale->obtain());
  }

  public function testLocaleCookieOverride()
  {
    // Simulates a browser header that prefers english
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en-US,en;q=0.8,es;q=0.6';
    $_COOKIE['prefered_lang'] = 'es';

    $locale = new Arosemena\LocaleChooser\LocaleChooser(['en', 'es', 'fr'], 'fr', 'prefered_lang');
    $this->assertEquals('es', $locale->obtain());
  }

}
<?php
namespace Arosemena\LocaleChooser;

class LocaleChooser
{
  private $default;
  private $available;
  private $cookieName;

  /**
   * @param array  $available  An array containing the available locales
   * @param string $default    The default language in case none is found
   * @param string $cookieName The name of the cookie that contains the preferred language
   */
  public function __construct($available = ['en', 'es', 'fr'], $default = 'en', $cookieName = 'preferred_language')
  {
    $this->available  = $available;
    $this->default    = $default;
    $this->cookieName = $cookieName;
  }

  /**
   * @return string Either the language stored on the cookie or null
   */
  private function cookie()
  {
    if (isset($_COOKIE[$this->cookieName])) {
      $preferred = $_COOKIE[$this->cookieName];
      if (in_array($preferred, $this->available)) {
        return $preferred;
      }
    }
    return null;
  }

  /**
   * The header is sent by most of the modern browsers, it looks something
   * like this en-US,en;q=0.8,es;q=0.6, I ignore the q value because it's
   * implicitly ordered by the browser
   *
   * @param string $header The HTTP header HTTP_ACCEPT_LANGUAGE from
   *                       the global $_SERVER array
   * @return string The 2 letter language identifier
   */
  private function process($header = "")
  {
    // check if the user sent a cookie containing a language and if the language if available
    if (!$this->cookie() && in_array($this->cookie(), $this->available)) {
      return $this->cookie();
    }
    $regex     = '/([a-zA-Z]{2});/';
    $languages = [];
    preg_match_all($regex, $header, $languages);
    foreach ($languages[1] as $language) {
      if (in_array($language, $this->available)) {
        return $language;
      }
    }
    return $this->default;
  }

  /**
   * Returns the locale based on the settings from the constructor
   *
   * @return string The 2 letter language identifier
   */
  public function obtain()
  {
    $header = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : null;
    if(!$header) { // If the server didn't receive the language header it returns the default language
      return $this->default;
    }
    return $this->process($header);
  }
}
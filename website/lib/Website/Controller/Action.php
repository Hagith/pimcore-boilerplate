<?php

namespace Website\Controller;

use Pimcore\Controller\Action\Frontend;
use Pimcore\Tool;

class Action extends Frontend
{
    /**
     * Cookie / request param name with user preferred language.
     *
     */
    const LANG_PARAM_NAME = 'lang';

    /**
     * @var \Website\Document\Page
     */
    public $document;

    /**
     * @var \Zend_Locale
     */
    public $locale;

    /**
     * @var string
     */
    public $language;

    /**
     * @var \Zend_Translate
     */
    protected $translate;

    public function init()
    {
        parent::init();

        if (\Zend_Registry::isRegistered('Zend_Locale')) {
            $this->locale = \Zend_Registry::get('Zend_Locale');
        } else {
            $this->locale = new \Zend_Locale('en');
            \Zend_Registry::set('Zend_Locale', $this->locale);
        }

        $this->view->language = $this->locale->getLanguage();
        $this->language = $this->locale->getLanguage();
        $this->translate = $this->initTranslation();

        \Zend_View_Helper_PaginationControl::setDefaultViewPartial('partial/pagination.php');
    }

    /**
     * Check request param and return language if valid.
     *
     * @return string|null
     */
    protected function getForcedLanguage()
    {
        $lang = $this->_getParam(self::LANG_PARAM_NAME);
        if ($lang && Tool::isValidLanguage($lang)) {
            return $lang;
        }

        return null;
    }

    /**
     * Get user preferred locale.
     *
     * @return string|null
     */
    protected function getPreferredLanguage()
    {
        if (!isset($_COOKIE[self::LANG_PARAM_NAME])) {
            return null;
        }

        $lang = $_COOKIE[self::LANG_PARAM_NAME];
        if (Tool::isValidLanguage($lang)) {
            return $lang;
        }

        return null;
    }

    /**
     * Set new preferred language if was changed.
     *
     * @param string $locale
     */
    protected function setPreferredLanguage($locale)
    {
        if($locale != $this->getPreferredLanguage()) {
            $expires = mktime(0, 0, 0, date('m'), date('d'), date('Y') + 5);
            setcookie(self::LANG_PARAM_NAME, $locale, $expires, '/');
        }
    }

    /**
     * Check user browser and choose first valid locale.
     *
     * @return string|null
     */
    protected function getBrowserLanguage()
    {
        $locale = null;

        // detection of user browser language preference
        $browser = \Zend_Locale::getBrowser();
        $valid = Tool::getValidLanguages();
        foreach ($browser as $lang => $p) {
            $lang = explode('_', $lang);
            if (in_array($lang[0], $valid)) {
                $locale = $lang[0];
                break;
            }
        }

        return $locale;
    }

    /**
     * Detect and return user language.
     *
     * @return string|null
     */
    protected function detectLanguage()
    {
        // check force switch
        $lang = $this->getForcedLanguage();

        if (!$lang) {
            $lang = $this->getPreferredLanguage();
        }

        if (!$lang) {
            // check user browser
            $lang = $this->getBrowserLanguage();
        }

        if (!$lang) {
            // use default
            $lang = Tool::getDefaultLanguage();
        }

        $this->setPreferredLanguage($lang);

        return $lang;
    }
}

<?php

namespace Website\Controller;

use Pimcore\Controller\Action\Frontend;

class Action extends Frontend
{
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
}

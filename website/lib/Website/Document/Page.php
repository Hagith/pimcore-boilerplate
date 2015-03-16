<?php

namespace Website\Document;

use Pimcore\Model\Document;

class Page extends Document\Page
{
    /**
     * @var array
     */
    protected $pagesOnPath;

    /**
     * @param boolean $callParent
     * @param bool $withSelf
     * @return array|string
     */
    public function getTitle($callParent = true, $withSelf = true)
    {
        if ($callParent) {
            return parent::getTitle();
        }

        $title = array();
        foreach ($this->getPagesOnPath($withSelf) as $page) {
            $pageTitle = trim($page->getTitle());
            if (empty($pageTitle)) {
                $pageTitle = trim($page->getProperty('navigation_name'));
            }
            if (!empty($pageTitle)) {
                $title[] = $pageTitle;
            }
        }

        return $title;
    }

    /**
     * @param boolean $callParent
     * @return string
     */
    public function getDescription($callParent = true)
    {
        if ($callParent) {
            return parent::getDescription();
        }

        foreach ($this->getPagesOnPath() as $page) {
            if ($page->getDescription()) {
                return $page->getDescription();
            }
        }

        return '';
    }

    /**
     * @param boolean $callParent
     * @return string
     */
    public function getKeywords($callParent = true)
    {
        if ($callParent) {
            return parent::getKeywords();
        }

        foreach ($this->getPagesOnPath() as $page) {
            if ($page->getKeywords()) {
                return $page->getKeywords();
            }
        }

        return '';
    }

    /**
     * @param boolean $withSelf
     * @return Document\Page[]
     */
    public function getPagesOnPath($withSelf = true)
    {
        if (is_array($this->pagesOnPath)) {
            return $this->pagesOnPath;
        }

        $this->pagesOnPath = [];
        if ($withSelf) {
            $this->pagesOnPath[] = $this;
        }

        $current = $this;
        while ($current = $current->getParent()) {
            if ($current instanceof Document\Page) {
                $this->pagesOnPath[] = $current;
            }
        }

        return $this->pagesOnPath;
    }
}

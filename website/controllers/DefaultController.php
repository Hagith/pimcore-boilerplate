<?php

use Website\Controller\Action;

class DefaultController extends Action
{
    public function init()
    {
        parent::init();

        $this->enableLayout();
    }

    public function defaultAction()
    {
    }
}

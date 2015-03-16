<?php

namespace Website\Controller\Plugin;

class EscapedFragment extends \Zend_Controller_Plugin_Abstract
{
    public function routeStartup(\Zend_Controller_Request_Abstract $request)
    {
        /** @var $request \Zend_Controller_Request_Http */
        if (!$request->isGet()) {
            return;
        }

        $host = 'http://' . $request->getHttpHost();
        $uri = \Zend_Uri_Http::fromString($host . $request->getRequestUri());

        $query = $uri->getQueryAsArray();
        if (!isset($query['_escaped_fragment_'])) {
            return;
        }

        $path = $uri->getPath() . ltrim($query['_escaped_fragment_'], '/');
        $uri->setPath($path);

        unset($query['_escaped_fragment_']);
        $uri->setQuery($query);

        $request->setRequestUri(str_replace($host, '', $uri->getUri()));
        $request->setPathInfo();
    }
}

<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initLocale()
    {


        $locale = null;
        $session = new Zend_Session_Namespace('accounts');

        

/*        if(!isset($session->session_id)){
            $session_id = md5 (microtime(true));
            $session->session_id = $session_id;
        }*/

        if ($session->locale) {
            $locale = new Zend_Locale($session->locale);
            //Zend_Debug::dump($locale);
        }
        if ($locale === null) {
//            try {
//                $locale = new Zend_Locale('browser');
//            } catch (Zend_Locale_Exception $e) {
                $locale = new Zend_Locale('ru_RU');
                $session->locale = 'ru_RU';
//            }
        }
        $this->lang = $session->locale;
        //echo $session->locale;
        $registry = Zend_Registry::getInstance();
        $registry->set('Zend_Locale', $locale);
        //print "HERE";

    }

    protected function _initTranslate()
    {

        $translate = new Zend_Translate('array', APPLICATION_PATH . '/languages/',  null,  array('scan' => Zend_Translate::LOCALE_DIRECTORY, 'disableNotices' => 1));

        $registry = Zend_Registry::getInstance();
        $registry->set('Zend_Translate', $translate);
    }
    
    protected function _initPlaceholders()
    {

        $this->bootstrap('View');
        $view = $this->getResource('View');
        $view->addScriptPath(APPLICATION_PATH . '/layouts/scripts');
        //$view->doctype('XHTML1_STRICT');

        // Set the initial title and separator:
        $view->headTitle($this->view->translate('page-title'))->setSeparator(' - ');

        // Set the initial stylesheet:
        $view->headLink()->appendStylesheet('/css/reset.css');
        $view->headLink()->appendStylesheet('/css/layout.css');
        $view->headLink()->appendStylesheet('/css/style.css');
        $view->headLink()->appendStylesheet('/themes/default/default.css');
        $view->headLink()->appendStylesheet('/css/nivo-slider.css');
        $view->headLink()->appendStylesheet('/css/menu_core.css');
        $view->headLink()->appendStylesheet('/css/menu_redBar.css');



        // Set the initial JS to load:
        $view->headScript()->appendFile('/js/jquery-1.7.1.min.js');
        $view->headScript()->appendFile('/js/cufon-yui.js');
        $view->headScript()->appendFile('/js/cufon-replace.js');
        $view->headScript()->appendFile('/js/Myriad_Pro_400.font.js');
        $view->headScript()->appendFile('/js/Myriad_Pro_700.font.js');
        $view->headScript()->appendFile('/js/Myriad_Pro_600.font.js');
        $view->headScript()->appendFile('/js/jquery.nivo.slider.pack.js');
        $view->headScript()->appendFile('/js/api.js');
        $view->headScript()->appendFile('/js/script.js');
        //$view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js');
        //$view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js');
        //$view->headScript()->appendFile('/js/jquery.tipsy.js');
        //$view->headScript()->appendFile('/js/jquery.nivo.slider.pack.js');
        //$view->headScript()->appendFile('/js/script.js');
        //$view->headScript()->appendFile('http://www.openlayers.org/api/OpenLayers.js');


    }


    /*protected function _initDoctrine()
    {
        require_once 'Doctrine/Doctrine.php';
        $this->getApplication()->getAutoloader()->pushAutoloader(array('Doctrine', 'autoload'), 'Doctrine');
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);
        $config = $this->getOption('doctrine');
        $conn = Doctrine_Manager::connection($config['dsn'], 'doctrine');
        return $conn;
    }*/



	/**
	 * used for handling top-level navigation
	 * @return Zend_Navigation
	 */
/*    protected function _initNavigation()
    {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation_en.xml', 'nav');

        $container = new Zend_Navigation($config);

        $translate = new Zend_Translate(
            array(
                'adapter' => 'xml',
                'content' => APPLICATION_PATH . '/configs/navigation_en.xml',
                'locale'  => 'en'
            )
        );
        $translate->addTranslation(
            array(
                'adapter' => 'xml',
                'content' => APPLICATION_PATH . '/configs/navigation_ro.xml',
                'locale'  => 'ro'
            )
        );
        //$view->navigation($container)->setTranslator($translate);
        $view->navigation($container);
        //RB setUseTranslator is unnecessary, because it's true by deafult



    }*/
/*
    protected function _initSidebar()
    {
        $this->bootstrap('View');
        $view = $this->getResource('View');

        $view->placeholder('sidebar')
             // "prefix" -> markup to emit once before all items in collection
             ->setPrefix("<div class=\"sidebar\">\n    <div class=\"block\">\n")
             // "separator" -> markup to emit between items in a collection
             ->setSeparator("</div>\n    <div class=\"block\">\n")
             // "postfix" -> markup to emit once after all items in a collection
             ->setPostfix("</div>\n</div>");
    }*/


}


<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
require dirname(__FILE__).'/../front.php';

/* Get Application
-------------------------------*/
print front()

/* Set Debug
-------------------------------*/
->setDebug(E_ALL, true)

/* Set Autoload
-------------------------------*/
->setLoader(NULL, '/module')

/* Set Paths
-------------------------------*/
->setPaths()

/* Start Filters
-------------------------------*/
->setFilters()

/* Trigger Init Event
-------------------------------*/
->trigger('init')

/* Set Database
-------------------------------*/
->setDatabases()

/* Set Timezone
-------------------------------*/
->setTimezone('Asia/Manila')

/* Trigger Init Event
-------------------------------*/
->trigger('config')

/* Start Session
-------------------------------*/
->startSession()

/* Trigger Session Event
-------------------------------*/
->trigger('session')

/* Set Request
-------------------------------*/
->setRequest()

/* Trigger Request Event
-------------------------------*/
->trigger('request')

/* Set Response
-------------------------------*/
->setResponse('Front_Page_Index')

/* Trigger Response Event
-------------------------------*/
->trigger('response');
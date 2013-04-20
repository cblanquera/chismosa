<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
require dirname(__FILE__).'/../assets.php';

/* Get Application
-------------------------------*/
print assets()

/* Set Autoload
-------------------------------*/
->setLoader(NULL, '/library')

/* Start Filters
-------------------------------*/
->setFilters()

/* Trigger Init Event
-------------------------------*/
->trigger('init')

/* Get the Response
-------------------------------*/
->getResponse();
<?php
/**
 * @package Open Tucson - Frontend
 * @author aslattery
 * @copyright MIT License
 */
// Load our configurations
require_once  __DIR__.'/conf.d/primary.conf.php';
require_once  __DIR__.'/conf.d/autoloader.php';
// Enable debug mode?
if(isset($config['interface']['debug']) && $config['interface']['debug']){
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
}
// Create app object w/ config array
$app = new OpenTucson\Frontend($config);
// Route request
$app->route($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

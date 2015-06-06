<?php
/**
 * @package Open Tucson - Frontend
 * @author aslattery
 * @copyright MIT License
 */
// Autoloader function
function autoloader($className){
  // Require frontend controller
  require_once __DIR__.'/../lib/Global/frontend.controller.php';
  // Setup class file to load
  $className = str_replace(
    array('OpenTucson\\', '\\'),
    array(null, '/'),
    $className
  );
  $fileName = __DIR__.'/../lib/'.$className.'.php';
  // If file, load.
  if (is_file($fileName)) {
    require_once $fileName;
  }
}
// SPL Register
spl_autoload_register('autoloader');

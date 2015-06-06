<?php
/**
 * @package Open Tucson - Frontend
 * @author aslattery
 * @copyright MIT License
 * @var $config is a KVP store for sitewide configurations
 *      including database, Mandrill, and other 3PA service
 *      tokens and API keys. Keys published are IP retricted
 *      for security purposes.
 */
$config = array(
  'interface' =>  array(
    'debug'     =>  true,
    'defLib'    =>  'Site',
    'defView'   =>  'Index'
  ),
  'database'  =>  array(
    'server'    =>  'openDb',
    'port'      =>  11700,
    'dbActual'  =>  'OpenTucson',
    'username'  =>  'frontendOp',
    'password'  =>  'OpenTucsonOp'
  ),
  'mandrill'  =>  array(
    'key'       =>  ''
  )
);
// Timezone override
date_default_timezone_set('UTC');

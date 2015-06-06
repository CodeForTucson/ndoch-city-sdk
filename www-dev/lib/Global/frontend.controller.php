<?php
/**
 * @package Open Tucson - Frontend
 * @author aslattery
 * @copyright MIT License
 */

namespace OpenTucson;

class Frontend {
  // Globals
  public static $config;
  public static $db;
  // Constructor, create config static var
  public function __construct($config){
    // Set globals
    self::$config = $config;
    self::$db = $this->initDatabase();
    // Start session handler
    session_start();
  }
  // Database Object
  public function initDatabase(){
    try {
      /*$dbcnx = new \mysqli(
        self::$config['database']['server'],
        self::$config['database']['username'],
        self::$config['database']['password'],
        self::$config['database']['dbActual'],
        self::$config['database']['port']
      );
      if ($dbcnx->connect_errno > 0){
        throw new \Exception('Failed to connect to database over intranet connection. Database handler reports error message " '.$dbcnx->connect_error.'"');
      }
      return $dbcnx;*/
    } catch (\Exception $e){
      // TODO: handle DB connect error
      return $e->getMessage();
    }
  }
  // Frontend Router
  public function route($method, $uri){
    // Switch method to set payload (if any)
    switch ($method) {
      case 'POST':
        $payload = $_POST;
        break;
      case 'GET':
        $payload = $_GET;
        break;
      default:
        $payload = $_GET;
        break;
      /**
       * As this is the frontend controller and handler,
       * we don't require a method case for PUT and DELETE.
       */
    }
    // Decode URI for routing information
    // Hard limit on '/'s set to 4
    $request = explode('/', trim($uri, '/'), 4);
    if (empty($request[0])){
      // Set to default view (homepage)
      $request[0] = self::$config['interface']['defLib'];
      $request[1] = self::$config['interface']['defView'];
    }
    // Determine offset
    $offset = (int) count($request) - 1;
    $offset == 2 ? $offset-- : $offset;
    // TODO: special case routing (devlog, user pages, etc.)
    // Load controller for this request
    $controllerName = 'ProjectAscension\\'.ucfirst($request[0]).'\\'.ucfirst($request[$offset]);
    if (class_exists($controllerName)){
      try {
        if ($controller = new $controllerName){
          call_user_func_array(array($controller, $method), array($request));
        } else {
          throw new \Exception('Failed to instantiate controller "'.$controllerName.'".');
        }
      } catch (\Exception $e){
        // TODO: controller execution failure handler, and render 404
      }
    } else {
      // TODO: better error handling for this.
      //echo '<br><h2>404-1 Controller Not Found</h2>';
      require_once __DIR__.'/../../res/wireframe/header.php';
      require_once __DIR__.'/../../lib/Site/templates/homepage.html';
      require_once __DIR__.'/../../res/wireframe/footer.php';
    }
  }
  // Rendering
  public static function render($template, $payload = null, $wrapper = true){
    // Check that template exists
    if (is_file($template)){
      // Using wrapper?
      if ($wrapper){
        require_once __DIR__.'/../../res/wireframe/header.php';
        require_once $template;
        require_once __DIR__.'/../../res/wireframe/footer.php';
      }
    } else {
      // TODO: better error handling for this.
      echo '<br><h2>404-2 Template Not Found';
    }
  }
}

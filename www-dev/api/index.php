<?php
/**
 * @package Open Tucson - Frontend
 * @author aslattery
 * @copyright MIT License
 */

namespace OpenTucson;

// API demo
class ApiDemo {
  public $endpoint;
  // Routing handler
  public function __construct($req){
    // Switch for requests
    switch($req['endpoint']){
      case 'farmers':
        $this->farmersMarket($req['params']['lat'], $req['params']['lng']);
        break;
    }
  }
  // cURL operator
  public function transmit($endpoint, $payload = null){
    $ch = curl_init();
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_URL, $endpoint);
          if($payload !== null){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
          }
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
          curl_setopt($ch, CURLOPT_TIMEOUT, 30);
          $result = curl_exec($ch);
          curl_close($ch);
    return $result;
  }
  // farmers-market
  public function farmersMarket($lat, $lng){
    $endpoint = 'http://search.ams.usda.gov/farmersmarkets/v1/data.svc/locSearch?lat='.$lat.'&lng='.$lng;
    // cURL endpoint
    $res = $this->transmit($endpoint);
    // Decode
    $res = json_decode($res, true);
    // Loop through, get details
    foreach($res as $resAct){
      foreach($resAct as $mkt){
        // Ok, let's get the market details
        $endpoint = 'http://search.ams.usda.gov/farmersmarkets/v1/data.svc/mktDetail?id='.$mkt['id'];
        $details = json_decode($this->transmit($endpoint), true);
        // Parse
        $markets[$mkt['id']] = array(
          'name'    =>  $mkt['marketname'],
          'address' =>  $details['marketdetails']['Address']
        );
      }
    }
    // Output response
    echo json_encode($markets);
  }
}

// Retreive request
$req = array(
  'endpoint' => key($_GET),
  'params'   => $_POST
);

// Handle request
$api = new ApiDemo($req);

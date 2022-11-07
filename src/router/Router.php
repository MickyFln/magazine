<?php

namespace router;

use Steampixel\Route;
use utilities\DefaultsProvider;

class Router
{
  const METHOD_GET = 'get';
  const METHOD_POST = 'post';
  const METHOD_PUT = 'put';
  const METHOD_DELETE = 'delete';

  protected DefaultsProvider $provider;

  function __construct(DefaultsProvider $provider)
  {
    $this->provider = $provider;
  }


  function initRoutes()
  {
    Route::add('/', function () {
      $magContr = $this->provider->getMagazineController();
      $magContr->viewMagazines();
    });

    Route::add('/add', function () {
      $magContr = $this->provider->getMagazineController();
      $magContr->showInputForm();
    }, self::METHOD_GET);

    Route::add('/add', function() {
      $jsonInputs = $this->getJsonDataFromRequest();
      $magContr = $this->provider->getMagazineController();
      $magContr->addMagazine($jsonInputs);
      //$magContr->showInputForm();
    }, self::METHOD_POST);

    Route::pathNotFound(function () {
      $logger = $this->provider->getLogger();
      $logger->debug('path not defined', $_REQUEST);
      echo 'path not found';
    });

    

    $baseUrl = getenv('BASE_URL');
    
    Route::run($baseUrl);
  }


  /*private function checkAuthHeader()
  {
    $logger = $this->provider->getLogger();
    $auth = $this->provider->getAuthenticator();
    $headers = $this->getRequestHeaders();
    $authToken = $headers['auth'];
    $logger->debug('headers', $headers);
    return $auth->checkAuthToken($authToken);
  }*/

  private function getJsonDataFromRequest()
  {
    $body = file_get_contents('php://input');
    return json_decode($body);
  }

  private function returnJsonResult($jsonResult)
  {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($jsonResult);
  }

  private function return403()
  {
  }

  private function getRequestHeaders()
  {
    $headers = array();
    foreach ($_SERVER as $key => $value) {
      if (substr($key, 0, 5) <> 'HTTP_') {
        continue;
      }
      $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
      $headers[$header] = $value;
    }
    return $headers;
  }
}

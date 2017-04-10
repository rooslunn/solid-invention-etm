<?php
// Routes

use Libs\DoAirFareRequest;
use Libs\GetAirFareResult;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;

$app->map(['GET', 'POST'], '/', function (Request $request, ResponseInterface $response, $args) {
    /* @var \Slim\Container $this */

    $error = '';
    $request_id = 0;

    if (empty($data = $request->getAttribute('post'))) {
        $data = [
            'departure_datetime' => '',
            'original_location' => 'Kaliningrad',
            'destination_location' => 'Moscow',
            'passangers_quantity' => '',
        ];
    } else {
        $original_location    = $this->cities->getCityByName($data['original_location']);
        $destination_location = $this->cities->getCityByName($data['destination_location']);

        $air_request = new DoAirFareRequest();
        $air_request->departure_datetime    = $data['departure_datetime'];
        $air_request->original_location     = empty($original_location['iso_3166_3']) ? false : $original_location['iso_3166_3'];
        $air_request->destination_location  = empty($destination_location['iso_3166_3']) ? false : $destination_location['iso_3166_3'];
        $air_request->passangers_quantity   = $data['passangers_quantity'];

        $air_response = $air_request->call();

        if (isset($air_response['response']->RequestId)) {
            $request_id = (int)$air_response['response']->RequestId;
        } else {
            $error = isset($air_response['response']) ? $air_response['response'] : 'Unknown error';
        }
    }

    $cities = $this->cities->getListForSelect();
    return $this->renderer->render($response, 'index.phtml', compact('args', 'cities', 'data', 'error', 'request_id'));
})->add($etm_ping);

$app->post('/ajax/results/{request_id}', function (Request $request, ResponseInterface $response, $args) {
    /* @var \Slim\Container $this */

    $request_id = (int)$args['request_id'];
    $air_request = new GetAirFareResult();
    $air_request->request_id = $request_id;
    $i = 0;
    do {
        $air_response = $air_request->call();
        if ($i !== 0) {
            sleep(1);
        }
        $i++;
    } while ((isset($air_response['code'])) && ($air_response['code'] == 201));

    if (isset($air_response['error']) && ($air_response['error'] == true)) {
        $data = [
            'status' => 'error',
            'error'  => isset($air_response['response']) ? $air_response['response'] : 'Unknown error',
        ];
    } else {
        $html = $this->renderer->fetch('result.phtml', ['cities' => $this->cities, 'data' => $air_response['response']]);
        $data = [
            'status'   => 'success',
            'response' => $html,
        ];
    }
    //$this->view->
    return $response->withJson($data, 201);
});

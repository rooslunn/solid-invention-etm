<?php
// Application middleware

use Libs\Ping;

$etm_ping = function ($request, $response, $next) {
    $ping = new Ping();
    $ping_response = $ping->call();
    if (isset($ping_response['error']) && $ping_response['error'] == true) {
        return $this->renderer->render($ping_response, 'etm_ping_error.phtml', $args);
    }
    return $next($request, $response);
};

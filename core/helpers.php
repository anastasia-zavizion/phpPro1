<?php
namespace Core;
use App\Enums\Http\Status;

function jsonResponse(int $code = 200, array $data = []): string
{
    header_remove();
    http_response_code($code);
    header("Cache-Control: no-transform,public,max-age:300,s-maxage=900");
    header("Content-Type: application/json");

    $statuses = [
        200 => '200 OK',
        400 => '400 Bad Request',
        403 => '403 Forbidden',
        422 => '422 Unprocessable Entity',
        404 => '404 Not found',
        500 => '500 Internal Server Error',
    ];

    header("Status: " . $statuses[$code]);

    return json_encode([
        'code' => $code,
        'status' => $statuses[$code],
        ...$data
    ]);
}

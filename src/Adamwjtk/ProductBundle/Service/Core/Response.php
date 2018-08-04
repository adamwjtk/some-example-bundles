<?php

namespace AdamwjtkProductBundle\Service\Core;

use Symfony\Component\HttpFoundation\JsonResponse;

class Response implements IResponse
{
    /**
     * @param int $statusCode
     * @param bool $status
     * @param string $message
     * @param array $extraData
     * @return JsonResponse
     */
    public function createResponse(int $statusCode, bool $status, string $message, array $extraData = []): jsonResponse
    {
        $response = new JsonResponse();
        $response->setStatusCode($statusCode);
        $response->setContent(json_encode(array(
            'status' => $status,
            'message' => $message,
            'body' => $extraData
        )));
        return $response;
    }
}
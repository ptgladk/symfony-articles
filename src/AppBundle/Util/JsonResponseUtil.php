<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseUtil
{
    /**
     * Success response
     *
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    public function success(array $data = array(), $status = Response::HTTP_OK)
    {
        $data['status'] = 'success';
        return new JsonResponse($data, $status);
    }

    /**
     * Error response
     *
     * @param $message
     * @param int $status
     * @return JsonResponse
     */
    public function error($message, $status = Response::HTTP_BAD_REQUEST)
    {
        return new JsonResponse(array('message' => $message, 'status' => 'error'), $status);
    }
}
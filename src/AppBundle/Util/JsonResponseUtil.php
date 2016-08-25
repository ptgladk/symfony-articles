<?php

namespace AppBundle\Util;

use Symfony\Component\Form\Form;
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

    /**
     * @param Form $form
     * @param int $status
     * @return JsonResponse
     */
    public function errorForm(Form $form, $status = Response::HTTP_BAD_REQUEST)
    {
        $errors = array();
        foreach ($form as $fieldName => $field) {
            $formErrors = $field->getErrors(true);
            foreach ($formErrors as $formError) {
                $errors[$fieldName][] = $formError->getMessage();
            }
        }

        return new JsonResponse(array('errors' => $errors, 'status' => 'error'), $status);
    }
}

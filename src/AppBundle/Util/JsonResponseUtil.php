<?php

namespace AppBundle\Util;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseUtil
{
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

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
        $headers = $this->_getHeaders();
        return new JsonResponse($data, $status, $headers);
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
        $headers = $this->_getHeaders();
        return new JsonResponse(array('message' => $message, 'status' => 'error'), $status, $headers);
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

        $headers = $this->_getHeaders();
        return new JsonResponse(array('errors' => $errors, 'status' => 'error'), $status, $headers);
    }

    /**
     * Get headers for api if they exist
     *
     * @return array
     */
    private function _getHeaders()
    {
        $headers = array();
        try {
            $headersConfig = $this->container->getParameter('api_headers');
        } catch(\Exception $e) {
            return $headers;
        }

        foreach ($headersConfig as $headerConfig) {
            $headers[$headerConfig['header']] = $headerConfig['value'];
        }

        return $headers;
    }
}

<?php

namespace AppBundle\Security;

use AppBundle\Util\JsonResponseUtil;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ApiKeyAccessDenied implements AccessDeniedHandlerInterface
{
    protected $response;
    protected $translator;

    /**
     * @param JsonResponseUtil $jsonResponse
     * @param Translator $trans
     */
    public function __construct(JsonResponseUtil $jsonResponse, Translator $trans)
    {
        $this->response = $jsonResponse;
        $this->translator = $trans;
    }

    /**
     * @param Request $request
     * @param AccessDeniedException $accessDeniedException
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        return $this->response->error(
            $this->translator->trans('error.forbidden'),
            Response::HTTP_FORBIDDEN
        );
    }
}

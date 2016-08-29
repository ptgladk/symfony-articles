<?php

namespace APIBundle\Controller;

use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function allAction()
    {
        return $this->get('app.json_response')->success(
            array(
                'data' => $this->get('serializer')->normalize(
                    $this->getDoctrine()->getRepository('AppBundle:Article')->findAll()
                )
            )
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction(Request $request)
    {
        $id = $request->get('id');
        if (empty($id) || !($article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id))) {
            return $this->get('app.json_response')->error(
                $this->get('translator')->trans('error.not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->get('app.json_response')->success(array(
            'data' => $this->get('serializer')->normalize(
                $article
            )
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(ArticleType::class, null, array('csrf_protection' => false));
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $article = $form->getData();
            $article->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->get('app.json_response')->success(array(), Response::HTTP_CREATED);
        }

        return $this->get('app.json_response')->errorForm($form);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function putAction(Request $request)
    {
        $id = $request->get('id');
        if (!($article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id))) {
            return $this->get('app.json_response')->error(
                $this->get('translator')->trans('error.not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        if ($article->getUser() != $this->getUser()) {
            return $this->get('app.json_response')->error(
                $this->get('translator')->trans('error.permission_denied'),
                Response::HTTP_FORBIDDEN
            );
        }

        $form = $this->createForm(ArticleType::class, $article, array('csrf_protection' => false));
        $form->submit($request->query->all());
        if ($form->isValid()) {
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->get('app.json_response')->success();
        }

        return $this->get('app.json_response')->errorForm($form);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction(Request $request)
    {
        $id = $request->get('id');
        if (!($article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id))) {
            return $this->get('app.json_response')->error(
                $this->get('translator')->trans('error.not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        if ($article->getUser() != $this->getUser()) {
            return $this->get('app.json_response')->error(
                $this->get('translator')->trans('error.permission_denied'),
                Response::HTTP_FORBIDDEN
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->get('app.json_response')->success();
    }
}

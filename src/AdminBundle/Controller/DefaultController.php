<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login_get');
        }
        return $this->redirectToRoute('admin_default');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function defaultAction()
    {
        return $this->render('AdminBundle:default:index.html.twig');
    }
}

<?php

namespace APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function authAction(Request $request)
    {
        $username = $request->request->get('username');
        if (empty($username)) {
            return $this->get('app.json_response')->error($this->get('translator')->trans('error.username_empty'));
        }
        $password = $request->request->get('password');
        if (empty($password)) {
            return $this->get('app.json_response')->error($this->get('translator')->trans('error.password_empty'));
        }

        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array(
            'username' => $username,
            'active' => true
        ));

        if (!$user || !password_verify($password, $user->getPassword())) {
            return $this->get('app.json_response')->error(
                $this->get('translator')->trans('error.credentials_incorrect')
            );
        }

        $token = $this->get('app.token_generator')->generate();
        $user->setToken($token);
        $user->setTokenDate(time());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->get('app.json_response')->success(array('username' => $username, 'token' => $token));
    }
}

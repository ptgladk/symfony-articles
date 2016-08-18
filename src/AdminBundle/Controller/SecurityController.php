<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginGetAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_default');
        }

        return $this->render('AdminBundle:security:login.html.twig', array(
            'error' => $request->get('error'),
            'username' => $request->get('username')
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginPostAction(Request $request)
    {
        $username = $request->request->get('username');
        if (empty($username)) {
            return $this->redirectToRoute('login_get', array('error' => 'Username is empty'));
        }
        $password = $request->request->get('password');
        if (empty($password)) {
            return $this->redirectToRoute('login_get', array(
                'error' => 'Password is empty',
                'username' => $username
            ));
        }

        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array(
            'username' => $username,
            'active' => true
        ));

        if (!$user || !password_verify($password, $user->getPassword())) {
            return $this->redirectToRoute('login_get', array(
                'error' => 'Username or password is incorrect',
                'username' => $username
            ));
        }

        $token = new UsernamePasswordToken($user, $password, 'admin', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);

        $user->setLoginDate(time());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin_default');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction()
    {
        $this->get('security.token_storage')->setToken(null);
        return $this->redirectToRoute('login_get');
    }
}
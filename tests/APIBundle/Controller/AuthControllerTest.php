<?php

namespace Tests\APIBundle\Controller;

class AuthControllerTest extends BaseTest
{
    /**
     * User authorization
     */
    public function testAuthAction()
    {
        $client = static::createClient();

        // Success
        $client->request('POST', '/auth', array('username' => 'user', 'password' => '123'));
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals($content['status'], 'success');
        $this->assertEquals($content['username'], 'user');
        $this->assertFalse(empty($content['token']));

        // Username is empty
        $client->request('POST', '/auth', array('password' => '123'));
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Username is empty');

        // Password is empty
        $client->request('POST', '/auth', array('username' => 'user'));
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Password is empty');

        // Username is incorrect
        $client->request('POST', '/auth', array('username' => 'user1', 'password' => '123'));
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Username or password is incorrect');

        // Password is incorrect
        $client->request('POST', '/auth', array('username' => 'user', 'password' => '111'));
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Username or password is incorrect');
    }
}

<?php

namespace Tests\APIBundle\Controller;

class ArticleControllerTest extends BaseTest
{
    /**
     * Get all articles
     */
    public function testAllAction()
    {
        $client = static::createClient();
        $headers = array(
            'HTTP_AUTHORIZATION' => $this->getToken('user', '123'),
        );
        $client->request('POST', '/api/article/favorite/2', array(), array(), $headers);

        // Get all
        $client->request('GET', '/api/article');
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals($content['status'], 'success');
        $this->assertTrue(is_array($content['data']));
        $this->assertEquals(count($content['data']), 3);
        $this->assertEquals($content['data'][0]['id'], 1);
        $this->assertEquals($content['data'][0]['title'], 'Title 1');
        $this->assertEquals($content['data'][0]['description'], 'Description 1');
        $this->assertEquals($content['data'][0]['content'], 'Content 1');
        $this->assertEquals($content['data'][0]['countInFavorites'], 0);
        $this->assertEquals($content['data'][0]['isFavorite'], false);
        $this->assertEquals($content['data'][0]['user']['id'], 1);
        $this->assertEquals($content['data'][0]['user']['username'], 'admin');
        $this->assertEquals($content['data'][1]['id'], 2);
        $this->assertEquals($content['data'][1]['title'], 'Title 2');
        $this->assertEquals($content['data'][1]['description'], 'Description 2');
        $this->assertEquals($content['data'][1]['content'], 'Content 2');
        $this->assertEquals($content['data'][1]['countInFavorites'], 1);
        $this->assertEquals($content['data'][1]['isFavorite'], false);
        $this->assertEquals($content['data'][1]['user']['id'], 1);
        $this->assertEquals($content['data'][1]['user']['username'], 'admin');
        $this->assertEquals($content['data'][2]['id'], 3);
        $this->assertEquals($content['data'][2]['title'], 'Title 3');
        $this->assertEquals($content['data'][2]['description'], 'Description 3');
        $this->assertEquals($content['data'][2]['content'], 'Content 3');
        $this->assertEquals($content['data'][2]['countInFavorites'], 0);
        $this->assertEquals($content['data'][2]['isFavorite'], false);
        $this->assertEquals($content['data'][2]['user']['id'], 2);
        $this->assertEquals($content['data'][2]['user']['username'], 'user');

        // Get by username
        $client->request('GET', '/api/article', array('username' => 'admin'));
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals($content['status'], 'success');
        $this->assertTrue(is_array($content['data']));
        $this->assertEquals(count($content['data']), 2);
        $this->assertEquals($content['data'][0]['id'], 1);
        $this->assertEquals($content['data'][0]['title'], 'Title 1');
        $this->assertEquals($content['data'][0]['description'], 'Description 1');
        $this->assertEquals($content['data'][0]['content'], 'Content 1');
        $this->assertEquals($content['data'][0]['countInFavorites'], 0);
        $this->assertEquals($content['data'][0]['isFavorite'], false);
        $this->assertEquals($content['data'][0]['user']['id'], 1);
        $this->assertEquals($content['data'][0]['user']['username'], 'admin');
        $this->assertEquals($content['data'][1]['id'], 2);
        $this->assertEquals($content['data'][1]['title'], 'Title 2');
        $this->assertEquals($content['data'][1]['description'], 'Description 2');
        $this->assertEquals($content['data'][1]['content'], 'Content 2');
        $this->assertEquals($content['data'][1]['countInFavorites'], 1);
        $this->assertEquals($content['data'][1]['isFavorite'], false);
        $this->assertEquals($content['data'][1]['user']['id'], 1);
        $this->assertEquals($content['data'][1]['user']['username'], 'admin');

        // Get all with token
        $client->request('GET', '/api/article', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals($content['status'], 'success');
        $this->assertTrue(is_array($content['data']));
        $this->assertEquals(count($content['data']), 3);
        $this->assertEquals($content['data'][0]['id'], 1);
        $this->assertEquals($content['data'][0]['title'], 'Title 1');
        $this->assertEquals($content['data'][0]['description'], 'Description 1');
        $this->assertEquals($content['data'][0]['content'], 'Content 1');
        $this->assertEquals($content['data'][0]['countInFavorites'], 0);
        $this->assertEquals($content['data'][0]['isFavorite'], false);
        $this->assertEquals($content['data'][0]['user']['id'], 1);
        $this->assertEquals($content['data'][0]['user']['username'], 'admin');
        $this->assertEquals($content['data'][1]['id'], 2);
        $this->assertEquals($content['data'][1]['title'], 'Title 2');
        $this->assertEquals($content['data'][1]['description'], 'Description 2');
        $this->assertEquals($content['data'][1]['content'], 'Content 2');
        $this->assertEquals($content['data'][1]['countInFavorites'], 1);
        $this->assertEquals($content['data'][1]['isFavorite'], true);
        $this->assertEquals($content['data'][1]['user']['id'], 1);
        $this->assertEquals($content['data'][1]['user']['username'], 'admin');
        $this->assertEquals($content['data'][2]['id'], 3);
        $this->assertEquals($content['data'][2]['title'], 'Title 3');
        $this->assertEquals($content['data'][2]['description'], 'Description 3');
        $this->assertEquals($content['data'][2]['content'], 'Content 3');
        $this->assertEquals($content['data'][2]['countInFavorites'], 0);
        $this->assertEquals($content['data'][2]['isFavorite'], false);
        $this->assertEquals($content['data'][2]['user']['id'], 2);
        $this->assertEquals($content['data'][2]['user']['username'], 'user');
    }

    /**
     * Get article
     */
    public function testGetAction()
    {
        $client = static::createClient();
        $headers = array(
            'HTTP_AUTHORIZATION' => $this->getToken('user', '123'),
        );
        $client->request('POST', '/api/article/favorite/2', array(), array(), $headers);

        // Get article
        $client->request('GET', '/api/article/2');
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals($content['status'], 'success');
        $this->assertTrue(is_array($content['data']));
        $this->assertEquals(count($content['data']), 7);
        $this->assertEquals($content['data']['id'], 2);
        $this->assertEquals($content['data']['title'], 'Title 2');
        $this->assertEquals($content['data']['description'], 'Description 2');
        $this->assertEquals($content['data']['content'], 'Content 2');
        $this->assertEquals($content['data']['countInFavorites'], 1);
        $this->assertEquals($content['data']['isFavorite'], false);
        $this->assertEquals($content['data']['user']['id'], 1);
        $this->assertEquals($content['data']['user']['username'], 'admin');

        // Get with token
        $client->request('GET', '/api/article/2', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals($content['status'], 'success');
        $this->assertEquals($content['data']['id'], 2);
        $this->assertEquals($content['data']['title'], 'Title 2');
        $this->assertEquals($content['data']['description'], 'Description 2');
        $this->assertEquals($content['data']['content'], 'Content 2');
        $this->assertEquals($content['data']['countInFavorites'], 1);
        $this->assertEquals($content['data']['isFavorite'], true);
        $this->assertEquals($content['data']['user']['id'], 1);
        $this->assertEquals($content['data']['user']['username'], 'admin');

        // Not found
        $client->request('GET', '/api/article/100');
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 404);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Not found');
    }

    /**
     * Create article
     */
    public function testPostAction()
    {
        $client = static::createClient();
        $headers = array(
            'HTTP_AUTHORIZATION' => $this->getToken('user', '123'),
        );

        // Success
        $data = array(
            'title' => 'New Title',
            'description' => 'New Description',
            'content' => 'New Content'
        );
        $client->request('POST', '/api/article', $data, array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 201);
        $this->assertEquals($content['status'], 'success');

        // Title is empty
        $data = array(
            'description' => 'New Description',
            'content' => 'New Content'
        );
        $client->request('POST', '/api/article', $data, array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertFalse(empty($content['errors']['title'][0]));
        $this->assertEquals($content['errors']['title'][0], 'This value should not be blank.');

        // Description is empty
        $data = array(
            'title' => 'New Title',
            'content' => 'New Content'
        );
        $client->request('POST', '/api/article', $data, array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertFalse(empty($content['errors']['description'][0]));
        $this->assertEquals($content['errors']['description'][0], 'This value should not be blank.');

        // Content is empty
        $data = array(
            'title' => 'New Title',
            'description' => 'New Description'
        );
        $client->request('POST', '/api/article', $data, array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertTrue(empty($content['errors']['description'][0]));
        $this->assertEquals($content['errors']['content'][0], 'This value should not be blank.');

        // Unauthorized
        $data = array(
            'title' => 'New Title',
            'description' => 'New Description',
            'content' => 'New Content'
        );
        $client->request('POST', '/api/article', $data);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 401);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Unauthorized');
    }

    /**
     * Update article
     */
    public function testPutAction()
    {
        $client = static::createClient();
        $headers = array(
            'HTTP_AUTHORIZATION' => $this->getToken('user', '123'),
        );

        // Success
        $data = array(
            'title' => 'New Title',
            'description' => 'New Description',
            'content' => 'New Content'
        );
        $client->request('PUT', '/api/article/3', $data, array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals($content['status'], 'success');

        // Title is empty
        $data = array(
            'description' => 'New Description',
            'content' => 'New Content'
        );
        $client->request('PUT', '/api/article/3', $data, array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertFalse(empty($content['errors']['title'][0]));
        $this->assertEquals($content['errors']['title'][0], 'This value should not be blank.');

        // Description is empty
        $data = array(
            'title' => 'New Title',
            'content' => 'New Content'
        );
        $client->request('PUT', '/api/article/3', $data, array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertFalse(empty($content['errors']['description'][0]));
        $this->assertEquals($content['errors']['description'][0], 'This value should not be blank.');

        // Content is empty
        $data = array(
            'title' => 'New Title',
            'description' => 'New Description'
        );
        $client->request('PUT', '/api/article/3', $data, array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertTrue(empty($content['errors']['description'][0]));
        $this->assertEquals($content['errors']['content'][0], 'This value should not be blank.');

        // Unauthorized
        $data = array(
            'title' => 'New Title',
            'description' => 'New Description',
            'content' => 'New Content'
        );
        $client->request('PUT', '/api/article/3', $data);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 401);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Unauthorized');

        // Forbidden
        $client->request('PUT', '/api/article/1', $data, array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 403);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'You do not have necessary permissions');

        // Not found
        $client->request('PUT', '/api/article/100', $data, array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 404);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Not found');
    }

    /**
     * Delete article
     */
    public function testDeleteAction()
    {
        $client = static::createClient();
        $headers = array(
            'HTTP_AUTHORIZATION' => $this->getToken('user', '123'),
        );

        // Success
        $client->request('DELETE', '/api/article/3', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals($content['status'], 'success');

        // Unauthorized
        $client->request('DELETE', '/api/article/3');
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 401);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Unauthorized');

        // Forbidden
        $client->request('DELETE', '/api/article/1', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 403);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'You do not have necessary permissions');

        // Not found
        $client->request('DELETE', '/api/article/100', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 404);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Not found');
    }

    /**
     * Add article in favorites
     */
    public function testPostFavoriteAction()
    {
        $client = static::createClient();
        $headers = array(
            'HTTP_AUTHORIZATION' => $this->getToken('user', '123'),
        );

        // Success
        $client->request('POST', '/api/article/favorite/1', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals($content['status'], 'success');

        // Article already in favorites
        $client->request('POST', '/api/article/favorite/1', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Article already was added in favorites');

        // Unauthorized
        $client->request('POST', '/api/article/favorite/2');
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 401);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Unauthorized');

        // Not found
        $client->request('POST', '/api/article/favorite/100', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 404);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Not found');
    }

    /**
     * Delete article in favorites
     */
    public function testDeleteFavoriteAction()
    {
        $client = static::createClient();
        $headers = array(
            'HTTP_AUTHORIZATION' => $this->getToken('user', '123'),
        );
        $client->request('POST', '/api/article/favorite/1', array(), array(), $headers);
        $client->request('POST', '/api/article/favorite/2', array(), array(), $headers);

        // Success
        $client->request('DELETE', '/api/article/favorite/1', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertEquals($content['status'], 'success');

        // Article is not in favorites
        $client->request('DELETE', '/api/article/favorite/1', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Article is not in favorites');

        // Unauthorized
        $client->request('DELETE', '/api/article/favorite/2');
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 401);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Unauthorized');

        // Not found
        $client->request('DELETE', '/api/article/favorite/100', array(), array(), $headers);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($client->getResponse()->getStatusCode(), 404);
        $this->assertEquals($content['status'], 'error');
        $this->assertEquals($content['message'], 'Not found');
    }
}

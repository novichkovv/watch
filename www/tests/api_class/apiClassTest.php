<?php

/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 02.09.2016
 * Time: 15:14
 */
class apiClassTest extends PHPUnit_Framework_TestCase
{
    public function testHaveRefreshToken()
    {
        $users_model = new default_model('users');
        $user = $users_model->getById(1);
        $this->assertTrue(!empty($user['refresh_token']));
    }
    
    public function testGetAccessToken()
    {
        $api = new feedly_api_class(1);
        $this->assertNotEmpty($api->access_token);
    }

//    public function testSearch()
//    {
//        $api = new feedly_api_class(1);
//        $res = $api->search('topic/tech');
//        $this->assertTrue(!empty($res));
//        $this->assertTrue(is_array($res));
//        print_r($res);
//        $this->assertEmpty($res['errorId']);
//    }

    public function testGetSubscriptions()
    {
        $api = new feedly_api_class(1);
        $res = $api->getSubscriptions();
        $this->assertTrue(!empty($res));
        $this->assertTrue(is_array($res));
        $this->assertEmpty($res['errorId']);
    }

    public function testGetFeed()
    {
        $api = new feedly_api_class(1);
        $res = $api->getFeed('feed/http://feeds.gawker.com/lifehacker/vip');
        $this->assertTrue(!empty($res));
        $this->assertTrue(is_array($res));
        $this->assertNotEmpty($res['id']);
        $this->assertEmpty($res['errorId']);
    }

    public function testGetFeeds()
    {
        $api = new feedly_api_class(1);
        $res = $api->getFeeds(['feed/http://feeds.gawker.com/lifehacker/vip', ['feed/http://www.digitaltrends.com/feed/?key=f00edf6a58d2a8740e624dda919cab37']]);
        $this->assertTrue(!empty($res));
        $this->assertTrue(is_array($res));
        $this->assertEmpty($res['errorId']);
    }

    public function testSubscribeUnsubscribe()
    {
        $api = new feedly_api_class(1);
        $api->unsubscribe(['feed/http://feeds.abcnews.com/abcnews/topstories']);

        $params = [
            [
                'categories' => [
                    [
                         'id' => 'user/af8adebe-dace-4da9-8e9e-7d25606777ee/category/news',
                         'label' => 'News'
                    ],
                ],
                'id' => 'feed/http://feeds.abcnews.com/abcnews/topstories',
                'title' => 'news'
            ]
        ];
        $api->subscribe($params);
        $check = false;
        foreach ($api->getSubscriptions() as $subscription) {
            if($subscription['id'] == 'feed/http://feeds.abcnews.com/abcnews/topstories') {
                $check = true;
                break;
            }
        }
        $this->assertTrue($check);

        $api->unsubscribe(['feed/http://feeds.abcnews.com/abcnews/topstories']);
        $check = false;
        foreach ($api->getSubscriptions() as $subscription) {
            if($subscription['id'] == 'feed/http://feeds.abcnews.com/abcnews/topstories') {
                $check = true;
                break;
            }
        }
        $this->assertFalse($check);
    }

    public function testGetStream()
    {
        $api = new feedly_api_class(1);
        $res = $api->getStream('feed/http://feeds.gawker.com/lifehacker/vip');
        $this->assertTrue(!empty($res));
        $this->assertTrue(is_array($res));
        $this->assertEmpty($res['errorId']);
        $this->assertNotEmpty($res['ids']);
    }

    public function testGetMix()
    {
        $api = new feedly_api_class(1);
        $mix = $api->getMix('topic/tech');
        $this->assertTrue(!empty($mix));
        $this->assertTrue(is_array($mix));
        $this->assertEmpty($mix['errorId']);
    }

    public function testGetEntry()
    {
        $model = new default_model('articles');
        $entry_id = $model->getAll('id DESC', '1')[0]['entry_id'];
        $api = new feedly_api_class(1);
        $res = $api->getEntry($entry_id);
        $this->assertTrue(!empty($res));
        $this->assertTrue(is_array($res));
        $this->assertEmpty($res['errorId']);
        $this->assertNotEmpty(1);
    }

    public function testGetEntries()
    {
        $model = new default_model('articles');
        $entry_ids = [];
        foreach ($model->getAll('id DESC', '3') as $item) {
            $entry_ids[] = $item['entry_id'];
        }
        $api = new feedly_api_class(1);
        $res = $api->getEntries($entry_ids);
        $this->assertTrue(!empty($res));
        $this->assertTrue(is_array($res));
        $this->assertEmpty($res['errorId']);
        $this->assertNotEmpty(1);
    }
}

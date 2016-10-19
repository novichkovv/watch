<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 02.09.2016
 * Time: 16:47
 */
class feedClassTest extends PHPUnit_Framework_TestCase
{
    private static $f;

    public static function setUpBeforeClass()
    {
        self::$f = new feed_class();
    }

    public function testGetArticles()
    {
        $articles_model = new default_model('articles');
        $articles_model->beginTransaction();
        $article_ids = [2404,2406];
        foreach ($article_ids as $article_id) {
            $articles_model->deleteById($article_id);
        }
        $articles_model->rollbackTransaction();
        $this->assertTrue(true);
//        $article_ids = [
//            ''
//        ]
    }
}
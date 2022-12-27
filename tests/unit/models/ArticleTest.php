<?php

namespace unit\models;

use app\models\Article;
use Codeception\Test\Unit;

class ArticleTest extends Unit
{
    /**
     * Проверка существующей статьи в базе данных.
     *
     * @return void
     */
    public function testFindArticleById(): void
    {
        verify($article = Article::findOne(['id' => 1]))->notEmpty();
        verify($article->title)->equals('Test Article');
        verify(Article::findOne(['id' => 2]))->empty();
    }

    /**
     * Проверка валидации атрибутов статьи.
     *
     * @return void
     */
    public function testValidationArticle(): void
    {
        $article = new Article();
        $article->title = null;
        $this->assertFalse($article->validate(['title']));

        $article->title = 'Повседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей деятельности влечет за собой пр';
        $this->assertFalse($article->validate(['title']));

        $article->title = 'Хороший заголовок';
        $this->assertTrue($article->validate(['title']));

        $article->content = null;
        $this->assertFalse($article->validate(['content']));

        $article->content = 1024;
        $this->assertFalse($article->validate(['content']));

        $article->content = 'Good content';
        $this->assertTrue($article->validate(['content']));

    }

    /**
     * Проверка метода tableName.
     *
     * @return void
     */
    public function testTableNameArticle(): void
    {
        $this->assertEquals('article', Article::tableName());
        $this->assertFalse('wrong_table' === Article::tableName());
    }

    /**
     * Проверка автоматического присвоения времени создания и обновления при сохранении в БД.
     *
     * @return void
     */
    public function testSaveArticle(): void
    {
        $article = new Article();
        $article->title = 'Test title article';
        $article->content = 'test article content';

        $article->save();
        $this->assertEquals(time(), $article->create_time);
        $this->assertEquals(time(), $article->update_time);
    }

}
<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Это класс модели для таблицы "application".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $create_time
 * @property int $update_time
 * @property int $author_id
 *
 * @property User $author
 */
class Application extends ActiveRecord
{
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName(): string
    {
        return 'application';
    }

    /**
     * @return array правила валидации для аттрибутов класса.
     */
    public function rules(): array
    {
        return [
            [['title', 'content', 'create_time', 'update_time', 'author_id'], 'required'],
            [['content'], 'string'],
            [['create_time', 'update_time', 'author_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * @return string[] названия аттрибутов класса для отображения.
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * Получает запрос для автора заявки.
     *
     * @return ActiveQuery автор заявки
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}

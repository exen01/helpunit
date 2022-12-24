<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

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
     * @return string Название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName(): string
    {
        return 'application';
    }

    /**
     * @return array Правила валидации для аттрибутов класса.
     */
    public function rules(): array
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['create_time', 'update_time', 'author_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * @return string[] Названия аттрибутов класса для отображения.
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Содержание',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * Получает запрос для автора заявки.
     *
     * @return ActiveQuery Автор заявки
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Получение ссылки на заявку.
     *
     * @return string URL статьи
     */
    public function getUrl(): string
    {
        return Url::to(['application/view', 'id' => $this->id]);
    }

    /**
     * Этот метод вызывается перед сохранением модели в базу данных.
     * Если это новая запись, то в create_time и update_time будет записана текущая временная метка Unix.
     *
     * @param bool $insert Вызывался ли этот метод при вставке записи. Если false, это означает, что метод вызывается при обновлении записи.
     * @return bool Результат сохранения записи. Если false, вставка записи или обновление будут отменены.
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->create_time = $this->update_time = time();
                $this->author_id = Yii::$app->user->id;
            } else {
                $this->update_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
}

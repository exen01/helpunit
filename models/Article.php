<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Это класс модели для таблицы "article".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $create_time
 * @property int $update_time
 */
class Article extends ActiveRecord
{
    /**
     * @return string Название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName(): string
    {
        return 'article';
    }

    /**
     * @return array Правила валидации для аттрибутов класса.
     */
    public function rules(): array
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 128],
            [['create_time', 'update_time'], 'integer'],
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
        ];
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
            } else {
                $this->update_time = time();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Получение ссылки на статью.
     *
     * @return string URL статьи
     */
    public function getUrl(): string
    {
        return Url::to(['article/view', 'id' => $this->id]);
    }
}
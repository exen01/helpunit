<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ApplicationSearch represents the model behind the search form of `app\models\Application`.
 */
class ApplicationSearch extends Application
{
    /**
     * @return array правила валидации для аттрибутов класса
     */
    public function rules(): array
    {
        return [
            [['id', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title', 'content'], 'safe'],
        ];
    }

    /**
     * @return array возвращает список сценариев и соответствующих активных атрибутов
     */
    public function scenarios(): array
    {
        // обход реализации сценариевт в родительском классе, если нужно
        return Model::scenarios();
    }

    /**
     * Создает экземпляр поставщика данных с примененным поисковым запросом.
     *
     * @param array $params параметры
     *
     * @return ActiveDataProvider данные
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Application::find();

        // если пользователь является абонентом, то показываем ему только его заявки
        if (Yii::$app->user->identity->role_id === 3) {
            $query->where(['author_id' => Yii::$app->user->identity->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // условия фильтрации списка
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}

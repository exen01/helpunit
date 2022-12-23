<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ArticleSearch представляет собой модель для поиска Article.
 */
class ArticleSearch extends Article
{
    /**
     * @return array название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
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
        $query = Article::find();

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
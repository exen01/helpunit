<?php

namespace app\controllers;

use app\models\Article;
use app\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ArticleController реализует действия CRUD для модели Article.
 */
class ArticleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Список всех моделей Article.
     *
     * @return string ответ пользователю
     */
    public function actionIndex(): string
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Отображает одну модель Article.
     * @param int $id ID
     * @return string ответ пользователю
     * @throws NotFoundHttpException если модель не найдена
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание новой модели Article.
     * Если создание прошло успешно, браузер будет перенаправлен на страницу просмотра.
     * @return string|Response ответ пользователю
     */
    public function actionCreate(): Response|string
    {
        $model = new Article();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Обновляет существующую модель Article.
     * Если обновление прошло успешно, браузер будет перенаправлен на страницу просмотра.
     * @param int $id ID
     * @return string|Response ответ пользователю
     * @throws NotFoundHttpException если модель не найдена
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Удаляет существующую модель Article.
     * Если удаление прошло успешно, браузер будет перенаправлен на «индексную» страницу.
     * @param int $id ID
     * @return Response ответ пользователю
     * @throws NotFoundHttpException если модель не найдена
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Находит модель статьи на основе ее значения первичного ключа.
     * Если модель не найдена, будет выдано исключение 404 HTTP.
     * @param int $id ID
     * @return Article загруженная модель
     * @throws NotFoundHttpException если модель не найдена
     */
    protected function findModel(int $id): Article
    {
        if (($model = Article::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}

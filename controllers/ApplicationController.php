<?php

namespace app\controllers;

use app\models\Application;
use app\models\ApplicationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ApplicationController реализует действия CRUD для модели Application.
 */
class ApplicationController extends Controller
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
     * Список моделей Application.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Отображает одну модель Application.
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
     * Создание новой модели Application.
     * Если создание прошло успешно, браузер будет перенаправлен на страницу просмотра.
     * @return string|Response ответ пользователю
     */
    public function actionCreate(): Response|string
    {
        $model = new Application();

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
     * Обновляет существующую модель Application.
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
     * Удаляет существующую модель Application.
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
     * @return Application загруженная модель
     * @throws NotFoundHttpException если модель не найдена
     */
    protected function findModel(int $id): Application
    {
        if (($model = Application::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}

<?php

namespace backend\controllers;

use backend\models\search\TimelineEventSearch;
use common\models\User;
use Yii;
use yii\web\Controller;

/**
 * Application timeline controller
 */
class TimelineEventController extends Controller
{
    public $layout = 'common';

    public function beforeAction($action)
    {
        if (Yii::$app->user->can(User::ROLE_SEO)) {
            return $this->redirect(['/seotools/manage']);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TimelineEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}

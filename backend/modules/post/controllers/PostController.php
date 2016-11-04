<?php

namespace backend\modules\post\controllers;

use backend\modules\post\models\Topic;
use Yii;
use common\models\Post;
use backend\modules\post\models\PostSearch;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 新建话题
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Topic();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $topService = new TopicService();
            if (!$topService->filterContent($model->title) || !$topService->filterContent($model->content)) {
                $this->flash('请勿发表无意义的内容', 'warning');
                return $this->redirect('create');
            }
            $model->user_id = Yii::$app->user->id;
            $model->type = 'topic';
            if ($model->tags) {
                $model->addTags(explode(',', $model->tags));
            }
            $rawContent = $model->content;
            $model->content = TopicService::replace($rawContent);
            if ($model->save()) {
                (new UserMeta)->saveNewMeta('topic', $model->id, 'follow');
                (new NotificationService())->newPostNotify(Yii::$app->user->identity, $model, $rawContent);
                // 更新个人总统计
                UserInfo::updateAllCounters(['post_count' => 1], ['user_id' => $model->user_id]);
                $this->flash('发表文章成功!', 'success');
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

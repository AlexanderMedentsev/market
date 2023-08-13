<?php

namespace app\controllers;

use app\models\Category;
use app\models\CategoryGroup;
use app\models\CategorySearch;
use app\models\CategoryForm;
use app\models\Group;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $form = new CategoryForm();
        $model = new Category();
        $form->name = $model->name;

        if ($this->request->isPost) {
//            try {
           // var_dump($form->load($this->request->post()));
            if ($form->load($this->request->post())) {
                //var_dump('aasdasd');
                $model->name = $form->name;
                $model->save();
                foreach ($form->groups as $groupId) {
                    $categoryGroup = new CategoryGroup();
                    $categoryGroup->id_category = $model->id;
                    $categoryGroup->id_group = $groupId;
                    $categoryGroup->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $model->loadDefaultValues();
            }
//            } catch (\Throwable $e) {
//                var_dump($e);
            }
            return $this->render('create', [
                'model' => $form,
            ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $form = new CategoryForm();
        $model = $this->findModel($id);
        $form->name = $model->name;
        $form->groups = ArrayHelper::getColumn(Group::find()->leftJoin('category_group', 'group.id = id_group')->andWhere(['category_group.id_category' => $id])->asArray()->all(), 'id');

        if ($this->request->isPost && $form->load($this->request->post())) {
            $model->name = $form->name;
            if (count($form->groups) > 0) {
                CategoryGroup::deleteAll(['in', 'id_category', $id]);
            }
            foreach ($form->groups as $groupId) {
                $categoryGroup = new CategoryGroup();
                $categoryGroup->id_category = $id;
                $categoryGroup->id_group = $groupId;
                $categoryGroup->save();
            }
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        CategoryGroup::deleteAll(['id_category' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

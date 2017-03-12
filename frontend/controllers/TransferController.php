<?php

namespace frontend\controllers;

use Yii;
use common\components\corecontrollers\ZeedController;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

use common\models\User;
use common\models\Transfer;
use common\models\search\TransferSearch;

class TransferController extends ZeedController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'send', 'ask'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * List all transfer made by the user
     * @return [type] [description]
     */
    public function actionIndex()
    {
        $searchModel = new TransferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View transfer detail
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Send money to other user
     * @return [type] [description]
     */
    public function actionSend()
    {
        $model = new Transfer();

        if (Yii::$app->request->post()) 
        {
            $post_transfer = Yii::$app->request->post('Transfer');
            $model->source_id = Yii::$app->user->id;
            $destination_username = $post_transfer['destination_username'];
            $destination = User::findByUsername($destination_username);

            if ( ! empty($destination) && $destination->id == Yii::$app->user->id)
                throw new NotFoundHttpException("Why do you send money to yourself?");

            if (empty($destination))
            {
                // create a new user id doesn't exist
                $destination = new User;
                $destination->username = $destination_username;
                $destination->email = 'guest_' . Yii::$app->getSecurity()->generateRandomString(20) . '@example.com'; // email is generated
                $destination->generateAuthKey();

                $destination->save();
            }

            $model->destination_username = $destination_username;
            $model->destination_id = $destination->id;
            $model->amount = $post_transfer['amount'];

            // begin transaction
            $connection = Yii::$app->getDb();
            $transaction = $connection->beginTransaction();

            try {
                $model->status = Transfer::STATUS_SUCCESS;
                $model->save();

                $destination->balance += $model->amount;
                $destination->save();
                
                $user = User::findOne(Yii::$app->user->id);
                $user->balance -= $model->amount;
                $user->save();

            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }
            catch (\Throwable $e)
            {
                $transaction->rollBack();
                throw $e;
            }

            $transaction->commit();

            return $this->redirect('index');

        }
        
        return $this->render('send', [
            'model' => $model,
        ]);
    }

    /**
     * Ask money from other user
     * //TODO
     * @return [type] [description]
     */
    public function actionAsk()
    {
    }

    /**
     * Finds the Transfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $user_id = Yii::$app->user->id;

        if (($model = Transfer::find()
            ->where([
                'and', 
                    'id='.$id, 
                    [
                        'or', 
                        'source_id = ' . $user_id,
                        'destination_id = ' . $user_id
                    ]])->one()) !== null) 
        {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
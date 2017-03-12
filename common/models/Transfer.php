<?php

namespace common\models;

use Yii;

use common\components\coremodels\ZeedActiveRecord;

/**
 * This is the model class for table "transfer".
 *
 * @property integer $id
 * @property integer $source_id
 * @property integer $destination_id
 * @property integer $amount
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $destination
 * @property User $source
 */
class Transfer extends ZeedActiveRecord
{

    // transfer's status
    const STATUS_PENDING = 'pending';
    const STATUS_FAILED  = 'failed';
    const STATUS_SUCCESS = 'success';

    public $destination_username;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'destination_id', 'created_at', 'updated_at'], 'integer'],
            [['amount', 'destination_username'], 'required'],
            [['amount'], 'integer', 'min' => 1],
            [['description'], 'string'],
            [['status', 'message'], 'string', 'max' => 255],
            [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['destination_id' => 'id']],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['source_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'ID'),
            'source_id'      => Yii::t('app', 'Source ID'),
            'destination_id' => Yii::t('app', 'Destination ID'),
            'amount'         => Yii::t('app', 'Amount'),
            'status'         => Yii::t('app', 'Status'),
            'message'        => Yii::t('app', 'Message'),
            'description'    => Yii::t('app', 'Description'),
            'created_at'     => Yii::t('app', 'Created At'),
            'updated_at'     => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestination()
    {
        return $this->hasOne(User::className(), ['id' => 'destination_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(User::className(), ['id' => 'source_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\activequery\TransferQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\activequery\TransferQuery(get_called_class());
    }
}
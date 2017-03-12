<?php

namespace common\models\activequery;

/**
 * This is the ActiveQuery class for [[\common\models\Transfer]].
 *
 * @see \common\models\Transfer
 */
class TransferQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Transfer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Transfer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
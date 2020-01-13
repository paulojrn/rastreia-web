<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\User;

class Webcontent extends ActiveRecord
{    
    public static function tableName()
    {
        return 'rwdb.webcontent';
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
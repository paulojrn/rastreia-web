<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $accessToken;
    
    public static function tableName()
    {
        return 'rwdb.user';
    }
    
    public function findByUsername($username)
    {
        $users = User::find()->all();
        
        foreach ($users as $user) {
            if (strcasecmp($user->getAttribute('username'), $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }
    
    public function validatePassword($password)
    {
        return $this->getAttribute('password') === $password;
    }
    
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
}
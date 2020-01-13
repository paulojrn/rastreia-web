<?php

namespace app\models;

use yii\base\Model;

/**
 * WebcontentForm is the model behind the web contents.
 */
class WebcontentForm extends Webcontent
{
    public $url;
    public $progress_status;
    public $user_id;
    public $http_status;
    public $response;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['url', 'progress_status', 'user_id'], 'required',  'message' => '{attribute} é obrigatório'],
            [['url'], 'url', 'defaultScheme' => 'http'],
            [['progress_status', 'user_id', 'http_status'], 'integer'],
            [['response'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'url' => 'URL',
            'progress_status' => 'Andamento',
            'http_status' => 'Status HTTP',
        ];
    }
}

<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Sistema de rastreamento de websites';
?>
<div class="site-index">
    <center><h1><?= $this->title; ?></h1></center>

    <div class="body-content">
        <div class="row center-block" style="width: 50%; margin-top: 5%;">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form'
                ]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group" style="text-align:center; margin-top: 5%;">
                    <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary', 'name' => 'login-button', 'style' => 'width: 20%;']) ?>              
                </div>

                <?php ActiveForm::end(); ?>

            </div>            
        </div>
    </div>    
</div>

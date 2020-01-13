<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\bootstrap\Modal;

?>

<div class="site-urls">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6">
                    <h4>Lista das urls cadastradas</h4>
                </div>
                <div class="col-md-6 text-right center-block">
                    <div class="btn-group"id="btns-group">
                        <?= Html::button('Adicionar URL', [
                            'class' => 'btn btn-success',
                            'onClick' => 'openModalAddUrl()']) ?>
                    </div>
                </div>
            </div>            
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?php Pjax::begin(['id' => 'grid-pjax']); ?>
                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'emptyText' => 'Sem resultados encontrados',
                            'columns' => [
                                [
                                    'attribute' => 'url',
                                    'label' => 'Url',
                                    'headerOptions' => ['style' => 'width: 60%;']
                                ],
                                [
                                    'attribute' => 'http_status',
                                    'label' => 'Status HTTP',
                                    'headerOptions' => ['style' => 'width: 10%;'],
                                    'value' => function($model){
                                        return is_null($model->http_status) ? 'Não rastreado' : ($model->http_status == 0 ? '-' : $model->http_status);
                                    }
                                ],
                                [                                    
                                    'class' => 'yii\grid\ActionColumn',                                    
                                    'headerOptions' => ['style' => 'width: 10%;'],
                                    'template' => '<center> {response} </center>',
                                    'buttons' => [
                                        'response' => function($url, $model, $key) {
                                            $html = '';
                                            
                                            if($model->response){
                                                $html = Html::a('<i class="glyphicon glyphicon-save"></i>', $url, ['class' => 'btn btn-xs']);
                                            }
                                            
                                            return $html;
                                        }
                                    ]
                                ]                
                            ],
                        ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    Modal::begin([
        'header' => 'Adicionar URL',
        'id' => 'modal-addurl',
        'size' => Modal::SIZE_LARGE,
    ]);

    echo Yii::$app->view->render('addurl');

    Modal::end();
?>

<script>
    var periodic = true;
    
    $(function() {
        if(periodic){
            setInterval(function() {    
                $.ajax({
                    url: 'index.php?r=site/get-page-data', 
                    type: 'get',
                    success: function(data, textStatus, jqXHR){// Anything data, String textStatus, jqXHR jqXHR                  
                        $.pjax.reload({container:"#grid-pjax",timeout: 10000});
                    }          
                });
            }, 30000); // every 30 seconds
            
            periodic = false;
        }
    });
    
    function openModalAddUrl(){
        $('#modal-addurl').modal('show');

        return false;
    }
</script>
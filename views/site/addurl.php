<?php
    use yii\helpers\Html;
?>

<div class="site-addurl">    
    <div class="row">
        <div class="col-md-2">
            <?= Html::submitButton('Adicionar', [
                'class' => 'btn btn-success',
                'onClick' => 'saveUrl()']); ?>
        </div>
        <div class="col-md-10">
            <?= Html::textInput('url-input', '', [
                'id' => 'url_input-id',
                'class' => 'form-control',
                'placeholder' => 'Sua URL aqui']) ?>
        </div>
    </div>
    <?= Html::hiddenInput('progress_status', 1, ['id' => 'progress_status-id']); ?>
    <?= Html::hiddenInput('user_id', Yii::$app->user->id, ['id' => 'user_id-id']); ?>
</div>

<script>
    function saveUrl(){
        let url = $('#url_input-id').val();
        let progressStatus = $('#progress_status-id').val();
        let userId = $('#user_id-id').val();
        
        $.ajax({
            url: 'index.php?r=site/save-url', 
            type: 'post',
            dataType: 'json',
            data: {
                url: url,
                progress_status: progressStatus,
                user_id: userId
            },
            success: function(data, textStatus, jqXHR){// Anything data, String textStatus, jqXHR jqXHR
                if(data.save){                    
                    $.pjax.reload({container:"#grid-pjax",timeout: 5000});
                }
                else{
                    console.log('Erro salvar URL');
                }
                
                $('#modal-addurl').modal('hide');
                $('#url_input-id').val('');
            },
            error: function(jqXHR, textStatus, errorThrown){// jqXHR jqXHR, String textStatus, String errorThrown
                console.log(errorThrown);
                
                $('#modal-addurl').modal('hide');
                $('#url_input-id').val('');
            }            
        });
    }
</script>
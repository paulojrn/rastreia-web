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
                'type' => 'url',
                'id' => 'url_input-id',
                'class' => 'form-control',
                'placeholder' => 'http://exemplo.com']) ?>
        </div>
    </div>
    <div id='aviso' style="display: none; margin-top: 1%;">
        <div class="alert alert-danger alert-dismissible">
            <strong>Erro!</strong> A URL informada não está correta.
        </div>
    </div>
    
    <?= Html::hiddenInput('progress_status', 1, ['id' => 'progress_status-id']); ?>
    <?= Html::hiddenInput('user_id', Yii::$app->user->id, ['id' => 'user_id-id']); ?>
</div>

<script type="text/javascript">
    $('#modal-addurl').on('hide.bs.modal',function(){
        $('#url_input-id').val('');
        $('#aviso').css('display', 'none');
    });

    function saveUrl(){
        let url = $('#url_input-id').val().trim();
        let progressStatus = $('#progress_status-id').val();
        let userId = $('#user_id-id').val();
        
        if(validateURL(url)){
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
                    $('#aviso').css('display', 'none');
                },
                error: function(jqXHR, textStatus, errorThrown){// jqXHR jqXHR, String textStatus, String errorThrown
                    console.log(errorThrown);

                    $('#modal-addurl').modal('hide');
                    $('#url_input-id').val('');
                    $('#aviso').css('display', 'none');
                }            
            });
        }
        else{
            $('#aviso').css('display', 'block');
        }        
    }
    
    function validateURL(urlToCheck) {
        var pattern = new RegExp("^((http|https|ftp)\://)*([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&%\$#\=~_\-]+))*$");
        return pattern.test(urlToCheck);
    }
</script>
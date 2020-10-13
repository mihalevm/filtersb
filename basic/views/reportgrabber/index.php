<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center">
                Сейчас будет выполнен поиск информации.<br/>От Вас потребуется введение подтверждающих кодов на отдельных этапах создания отчета.
            </h4>
        </div>
    </div>
    <div class="row control-tools">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary pull-right" onclick="nexStep()">Начать</button>
        </div>
    </div>
</div>

<script language="JavaScript">
    function nexStep() {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.post(window.location.origin + '/reportgrabber', {
            s: 'E',
            did: $('#drv-item-'+$('#property-driver').data('did')).data('did'),
            rid: $('#property-driver').data('rid'),
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }
</script>
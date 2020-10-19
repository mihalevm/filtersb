<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center">
                Отчет по водителю сформирован, Вы можете получить на почту или скачать.
            </h4>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-6">
            <button type="button" class="btn btn-primary pull-right" onclick="sendReport()">На почту</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-primary pull-left" onclick="ReportDownload()">Скачать</button>
        </div>
    </div>
    <div class="row control-tools">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary pull-right" onclick="closeReport()">Завершить</button>
        </div>
    </div>
</div>

<script language="JavaScript">
    function sendReport() {
        $.post(window.location.origin + '/reportgrabber/sendreport?rid=<?=$rid?>', {
        }, function (data) {
            if ( parseInt(data) == 1 ){
                $('#generate-report').modal('hide');
                $('#rep-engine-content').html('');
            };
        });
    }

    function ReportDownload () {
        window.open(window.location.origin + '/reportgrabber/getreport?rid=<?=$rid?>', '_blank');

        return;
    }

    function repeatStep() {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.post(window.location.origin + '/reportgrabber', {
            s: 'finish',
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
            rid:<?=$rid?>
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }

    function closeReport() {
        $('#generate-report').modal('hide');
    }
</script>
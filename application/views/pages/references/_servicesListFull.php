<div class="jsGrid services-list-full_jsGrid"></div>

<script>
    $(function(){
        var rows = [];
        var row;
        var tpl;

        <?
        if (!empty($servicesListFull)) {
            foreach($servicesListFull as $service) {
            $measure = explode(';', $service['MEASURE']);
            ?>
            row = {
                'SERVICE_ID'    : '<?=$service['SERVICE_ID']?>',
                'SERVICE_NAME'  : '<?=$service['SERVICE_NAME']?>',
                'FULL_NAME'     : '<?=$service['LONG_DESC']?>',
                'MEASURE'       : '<?=$measure[0]?>',
            };
            rows.push(row);
        <?
            }
        }
        ?>

        sources_drawTable(rows);
    });

    function sources_drawTable(rows)
    {
        var grid = $(".services-list-full_jsGrid");

        grid.jsGrid({
            width: '100%',

            data: rows,

            fields: [
                { name: "SERVICE_ID", type: "text", title: 'ID', width:50},
                { name: "SERVICE_NAME", type: "text", title: 'Наименование', width:200},
                { name: "FULL_NAME", type: "text", title: 'Полное наименования', width:300},
                { name: "MEASURE", type: "text", title: 'Размерность', width:100}
            ]
        });
    }
</script>
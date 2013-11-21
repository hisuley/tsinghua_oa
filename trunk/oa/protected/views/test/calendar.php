<?php
/**
 * Created by Kimi Tourism.
 * @author Suley<luzhang@jmlvyou.com>
 * @time 13-11-11
 * @version 1.0
 * @copyright 
 **/
?>
<script type="text/javascript">

    $(document).ready(function() {

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            events: [
                {
                    title: '唐山项目签订仪式',
                    start: new Date(y, m, 1)
                },
                {
                    title: '测试时间',
                    start: new Date(y, m, d-5),
                    end: new Date(y, m, d-2)
                },
                {
                    id: 999,
                    title: '财务报销',
                    start: new Date(y, m, d-3, 16, 0),
                    allDay: false
                },
                {
                    id: 999,
                    title: '河北项目立项',
                    start: new Date(y, m, d+4, 16, 0),
                    allDay: false
                },
                {
                    title: '山东项目验收',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false
                },
                {
                    title: '某镇城市规划',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false
                },
                {
                    title: '每周例会',
                    start: new Date(y, m, d+1, 19, 0),
                    end: new Date(y, m, d+1, 22, 30),
                    allDay: false
                },
                {
                    title: '通知',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/'
                }
            ]
        });

    });


</script>
<div class="substance">
    <div class="leftside" style="width:1100px">
        <a href="<?php echo $this->createUrl('site/userlist'); ?>">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
        </a>
        <a class="tittle3" href="<?php echo $this->createUrl('site/userlist'); ?>">日历</a>
        <div id="calendar" style="width:900px;margin-left:100px;"></div>
    </div>
</div>
<style>
    table{
        border:0px;
    }
    table td{
        border:0px;
    }
</style>
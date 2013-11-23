<!--中间录入部分-->
<div class="substance">
    <!--左侧录入-->
    <div class="leftside" >
        <a href="#">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_orange.png">
        </a>
        <a class="tittle3" href="#">审批</a>
        <!--下拉选择-->
        <div >

        </div>

        <p>单位：小时</p>
        <table>
            <thead>
                <tr>
                    <th>编号</th>
                    <th>填报人</th>
                    <th>类型</th>
                    <th>填报时间</th>
                    <th>时长</th>
                    <th>加班</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($result as $manhour){
                $isolatedManhour = Manhour::calculateManhour($manhour);
                echo "<tr";
                switch($manhour->status){
                    case 'end':
                        echo "";
                        break;
                    case 'start':
                        echo '';
                        break;
                    case 'un-sign-off':
                        echo " class='red'";
                        break;
                    case 'complete':
                        echo " class='green'";
                        break;

                }
                echo ">";
                echo "<td>".$manhour->id."</td>";
                echo "<td>";
                echo empty($manhour->user->realname) ? $manhour->user->username : $manhour->user->realname;
                echo "</td>";
                echo "<td>";
                echo Manhour::translateType($manhour->type);
                echo "</td>";
                echo "<td>".date('Y-m-d h:i:s',$manhour->create_time)."</td>";
                echo "<td>".intval($isolatedManhour['manhour']/3600)."</td>";
                echo "<td>".intval($isolatedManhour['overtime']/3600)."</td>";
                echo "<td>";
                echo Manhour::translateStatus($manhour->status);
                echo "</td>";
                echo "<td><a href='".$this->createUrl('manhour/edit', array('id'=>$manhour->id, 'type'=>$manhour->type))."'>修改</a> ";
                echo ($manhour->is_review || ($manhour->status != 'end')) ? '' : "| <a href='".$this->createUrl('manhour/review', array('id'=>$manhour->id))."'>通过</a> ";
                echo "| <a class='delete-manhour' href='".$this->createUrl('manhour/delete', array('id'=>$manhour->id))."'>删除</a>";
            }
            ?>
            </tbody>

        </table>

        <!--付款方式-->

        <button class="submit_button button_orange" type="submit">提交</button>
    </div>
    <!--右侧选择-->
    <div class="rightside rightside_shenpi">
        <h3 style="padding-left: 35px;">工时与加班审批</h3>
        <div class="menu">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_leftshen.png">
            <a href="#">最新数据</a>
        </div>
        <div class="menu">
            <a href="#">全部数据</a>
        </div>
    </div>
    <div style="clear:both;float:none;"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
       $('a.delete-manhour').click(function(){
          return confirm('您确定要删除该工时数据吗？');
       });
    });
</script>
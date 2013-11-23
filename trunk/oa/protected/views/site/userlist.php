<!--中间录入部分-->
<div class="substance">
    <div class="leftside" style="width:1100px">
        <a href="#">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
        </a>
        <a class="tittle3" href="#">系统首页</a>
        <div class="tittle2">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/people.png">
            <h2 style="color:#02d1b1;display: inline-table;margin-top: -10px">用户管理</h2>
        </div>
        <table class="qingjiashenpi yonghuguanli">
            <thead>
                <th>用户名称</th>
                <th>邮箱</th>
                <th>职位</th>
                <th>创建时间</th>
                <th>操作</th>
            </thead>
            <tbody>
            <?php foreach($result as $user){
                echo "<tr>";
                echo "<td>";
                echo empty($user->realname) ? $user->username : $user->realname;
                echo "</td>";
                echo "<td>".$user->email."</td>";
                echo "<td>".User::translateRole($user->role)."</td>";
                echo "<td>".date('Y-m-d', $user->create_time)."</td>";
                echo '<td><a href="'.$this->createUrl('site/user', array('id'=>$user->id)).'">修改</a><span style="display:inline">|</span><a class="delete-user" href="'.$this->createUrl('user/delete', array('id'=>$user->id)).'">删除</a></td>';
                echo "</tr>";

            }?>
            <tr>
                <td colspan="5"><a href="<?php echo $this->createUrl('site/user'); ?>">添加新用户</a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('a.delete-user').click(function(){
           return confirm('您是否要删除该用户？此操作无法撤销！');
        });
    })
</script>
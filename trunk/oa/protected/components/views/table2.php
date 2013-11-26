<table class="tablelist3 tablelist4 reimbursement-2">
    <thead>
        <tr>
            <th>前往机场车站及出差当地交通费（含当地打车、高速过桥费）</th>
            <th>往返机票及火车票合计</th>
            <th>出差当地餐费</th>
            <th>住宿费</th>
            <th>其中本人垫付长途交通费</th>
            <th>其他</th>
            <th>备注</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($result)){ ?>
        <tr>
            <td><input type="text" name="ReimbursementForm[content][traffic_fee][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][traffic][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][local_meal][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][hotel][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][self_fee][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][other][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][memo][]" value=""></td>
            <td><a href="#" class="removeThis">删除</a></td>
        </tr>
        <?php }else{ ?>
        <?php foreach($result['traffic_fee'] as $key=>$value){
            echo "<tr>";
            echo '<td><input type="text" name="ReimbursementForm[content][traffic_fee][]" value="'.$value.'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][traffic][]" value="'.$result['traffic'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][local_meal][]" value="'.$result['local_meal'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][hotel][]" value="'.$result['hotel'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][self_fee][]" value="'.$result['self_fee'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][other][]" value="'.$result['other'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][memo][]" value="'.$result['memo'][$key].'"></td>';
            echo '<td><a href="#" class="removeThis">删除</a></td>';
            echo "</tr>";
        } 
    } ?>
</tbody>
</table>
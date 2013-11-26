<table class="tablelist3 tablelist4 reimbursement-1">
    <thead>
        <tr>
            <th>市内交通费</th>
            <th>公务餐费、招待餐费</th>
            <th>加班餐费</th>
            <th>其他</th>
            <th>备注</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($result)){ ?>
        <tr>
            <td><input type="text" name="ReimbursementForm[content][traffic][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][meals][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][overtime_meals][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][other][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][memo][]" value=""></td>
            <td><a href="#" class="removeThis">删除</a></td>
        </tr>
        <?php }else{ ?>
        <?php foreach($result['traffic'] as $key=>$value){
                echo "<tr>";
                echo '<td><input type="text" name="ReimbursementForm[content][traffic][]" value="'.$value.'"></td>';
                echo '<td><input type="text" name="ReimbursementForm[content][meals][]" value="'.$result['meals'][$key].'"></td>';
                echo '<td><input type="text" name="ReimbursementForm[content][overtime_meals][]" value="'.$result['overtime_meals'][$key].'"></td>';
                echo '<td><input type="text" name="ReimbursementForm[content][other][]" value="'.$result['other'][$key].'"></td>';
                echo '<td><input type="text" name="ReimbursementForm[content][memo][]" value="'.$result['memo'][$key].'"></td>';
                echo '<td><a href="#" class="removeThis">删除</a></td>';
                echo "</tr>";
            } 
         } ?>
    </tbody>
</table>
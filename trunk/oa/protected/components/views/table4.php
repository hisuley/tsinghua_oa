<table class="tablelist3 tablelist4 reimbursement-4">
    <thead>
        <tr>
            <th>大数额办公用品</th>
            <th>购买人</th>
            <th>物品数量</th>
            <th>购买数量</th>
            <th>单价</th>
            <th>总价</th>
            <th>经办人</th>
            <th>购买日期</th>
            <th>付款方式</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($result)){ ?>
        <tr>
            <td><input type="text" name="ReimbursementForm[content][item][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][reviewer][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][name][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][amount][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][price][]" value=""></td>
            <td><input type="text" name="ReimbursementForm[content][total_price][]" value=""></td>
             <td><input type="text" name="ReimbursementForm[content][agent]" value=""></td>
             <td><input type="text" name="ReimbursementForm[content][date][]" value=""></td>
              <td><input type="text" name="ReimbursementForm[content][payment][]" value=""></td>
            <td><a href="#" class="removeThis">删除</a></td>
        </tr>
        <?php }else{ ?>
        <?php foreach($result['item'] as $key=>$value){
            echo "<tr>";
            echo '<td><input type="text" name="ReimbursementForm[content][item][]" value="'.$value.'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][reviewer][]" value="'.$result['reviewer'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][name][]" value="'.$result['name'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][amount][]" value="'.$result['amount'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][price][]" value="'.$result['price'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][total_price][]" value="'.$result['total_price'][$key].'"></td>';
             echo '<td><input type="text" name="ReimbursementForm[content][agent][]" value="'.$result['agent'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][date][]" value="'.$result['date'][$key].'"></td>';
            echo '<td><input type="text" name="ReimbursementForm[content][payment][]" value="'.$result['payment'][$key].'"></td>';
            echo '<td><a href="#" class="removeThis">删除</a></td>';
            echo "</tr>";
        } 
    } ?>
</tbody>
</table>
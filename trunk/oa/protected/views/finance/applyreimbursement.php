<script type="text/javascript">
    $(document).ready(function(){
      $('div.radio-group>label').bind('click', function(){
        var inputId = $(this).prop('for');
        input$ = $('#'+inputId);
        input$.prop('checked', true);
        $(this).parent().find('label.checked').removeClass('checked');
        $(this).toggleClass('checked');

      });
    });
  </script>
<!--中间录入部分-->
					<div class="substance">
						<!--左侧录入-->
						<div></div>
						<div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
							</a>
							<a class="tittle3" href="#">新建与申请</a>
							<form action="<?php echo $this->createUrl('finance/reimbursement'); ?>" method="POST"> 
								<p>创建日期：<?php echo date('Y-m-d');?></p>
								</br>
								<input class="inputlist" name="ReimbursementForm[name]" id="projectName" type="text" value="<?php if(isset($result)){echo $result->name; }?>">
  								</br>
  								<label class="xuhao">费用项目:</label>
  								<input name="ReimbursementForm[item]" class="inputlist2" type="text"  value="<?php if(isset($result)){echo $result->name; }?>"/>
  								</br>
  								<label class="xuhao">负责人:</label>
  								<select name="ReimbursementForm[username]"  value="<?php if(isset($result)){echo $result->name; }?>">
                                    <?php
                                    $users = User::getUserList();
                                    foreach($users as $user){
                                        echo "<option value='".$user->username."'>".$user->realname."</option>";
                                    }
                                    ?>
                                </select>
  								</br>
  								<label class="xuhao">报销金额:</label>
  								<input name="ReimbursementForm[price]" class="inputlist2" type="text" value="<?php if(isset($result)){echo $result->name; }?>"/>
  								</br>
  								<label class="xuhao">报销类型:</label>
  								<div class="radio-group">
	  								<input  id="radio_one" type="radio" name="ReimbursementForm[type]" value="市内出差" />
	  								<label for="radio_one">市内出差</label>
	  								<input id="radio_two" type="radio" name="ReimbursementForm[type]" value="市外出差" />
	  								<label for="radio_two">室外出差</label>
	  								<input id="radio_three" type="radio" name="ReimbursementForm[type]" value="日常花销" />
	  								<label for="radio_three">日常花销</label>
	  								<input id="radio_four" type="radio" name="ReimbursementForm[type]" value="办公用品" />
	  								<label for="radio_gour">办公用品</label>
	  							</div>
	  							</br>
	  							<label class="xuhao">报销内容:</label>
                                <!--市内出差-->
                                <table class="tablelist3 tablelist4 reimbursement-1">
                                    <thead>
                                    <tr>
                                        <th>市内交通费</th>
                                        <th>公务餐费、招待餐费</th>
                                        <th>加班餐费</th>
                                        <th>其他</th>
                                        <th>备注</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="ReimbursementForm[content][traffic]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][meals]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][overtime_meals]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][other]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][memo]" value=""></td>
                                        </tr>
                                    </tbody>
                                </table>


  								<button class="submit_button" type="submit">提交</button>	
							</form>
                            <div style="display:none;">
                                <!--市内出差-->
                                <table class="tablelist3 tablelist4 reimbursement-1">
                                    <thead>
                                        <tr>
                                            <th>市内交通费</th>
                                            <th>公务餐费、招待餐费</th>
                                            <th>加班餐费</th>
                                            <th>其他</th>
                                            <th>备注</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="ReimbursementForm[content][traffic]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][meals]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][overtime_meals]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][other]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][memo]" value=""></td>

                                        </tr>
                                    </tbody>

                                </table>
                                <!--市外出差-->
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
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="ReimbursementForm[content][traffic_fee]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][traffic]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][local_meal]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][hotel]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][self_fee]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][other]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][memo]" value=""></td>
                                            
                                        </tr>
                                    </tbody>

                                </table>
                                <!--办公用品：普通办公用品与大额办公用品-->
                                <!--普通办公用品-->
                                <table class="tablelist3 tablelist4 reimbursement-3">

                                    <thead>
                                        <tr>
                                            <th>普通办公用品</th>
                                            <th>购买人</th>
                                            <th>监督人</th>
                                            <th>物品名称</th>
                                            <th>其购买数量</th>
                                            <th>单价</th>
                                            <th>总价</th>
                                            <th>购买日期</th>
                                            <th>付款方式</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="ReimbursementForm[content][item]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][buyer]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][reviewer]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][name]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][amount]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][price]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][total_price]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][date]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][payment]" value=""></td>
                                        </tr>
                                    </tbody>

                                </table>
                                <!--大数额办公用品-->
                                <table class="tablelist3 tablelist4 reimbursement-4">
                                    <thead>
                                        <tr>
                                            <th>大数额办公用品</th>
                                            <th>物品名称</th>
                                            <th>其购买数量</th>
                                            <th>单价</th>
                                            <th>总额</th>
                                            <th>经办人</th>
                                            <th>购买日期</th>
                                            <th>付款方式</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="ReimbursementForm[content][item]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][name]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][amount]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][price]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][total_price]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][agent]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][date]" value=""></td>
                                            <td><input type="text" name="ReimbursementForm[content][payment]" value=""></td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
							<script type="text/javascript">
	  							$(document).ready(function(){
	  								$('#addNewFinaceItem').bind('click', function(){
	  									var trSize = $('#financeTable').find('tr').size();
	  									console.log(trSize);
	  									var htmlTr = "<tr><td><input name='ReimbursementForm[content]["+trSize+"][name]' ></td>";
	  									var htmlTr = htmlTr+"<td><input name='ReimbursementForm[content]["+trSize+"][price]' ></td>";
	  									var htmlTr = htmlTr+"<td><input name='ReimbursementForm[content]["+trSize+"][total_price]' ></td>";
	  									var htmlTr = htmlTr+"<td><input name='ReimbursementForm[content]["+trSize+"][amount]' ></td>";
	  									var htmlTr = htmlTr+"<td><input name='ReimbursementForm[content]["+trSize+"][note]' ></td></tr>";
	  									$('#financeTable').append(htmlTr);
	  									return false;
	  								});
                                    $('input[name="ReimbursementForm[type]"]').click(function(){
                                        console.log('type changed');
                                        $('#addNewFinanceItem').next('table').remove();
                                        switch($(this).val()){
                                            case '市内出差':
                                                $('#addNewFinanceItem').after($('.reimbursement-1').last().clone());
                                                break;
                                            case '市外出差':
                                                $('#addNewFinanceItem').after($('.reimbursement-2').last().clone());
                                                break;
                                            case '日常花销':
                                                $('#addNewFinanceItem').after($('.reimbursement-3').last().clone());
                                                break;
                                            case '办公用品':
                                                $('#addNewFinanceItem').after($('.reimbursement-4').last().clone());
                                                break;
                                        }
                                    });
	  							});

	  						</script>
	  						<style>
	  							table#financeTable tr td input{
	  								width:60px;
	  								height:35px;
	  								margin:0px;
	  								padding:0px;
	  								padding-left:5px;
	  							}
	  						</style>
						</div>
						<!--右侧选择-->
						<div class="rightside" class="rightside_xinjianyushenqing">
							<h3>报销申请</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_left.png">
								<a href="#">报销记录</a>	
							</div>
							<div class="plusline" >
								<a href="#">
									<img class="plus"src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/plus.png"></a>	
							</div>
							<img id="tanhao" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/tanhao.png">
							<p>请先提交再创建新报销记录!</p>
						</div>
						<!--日历-->
						<div style="clear:both;float:none;"></div>
					</div>
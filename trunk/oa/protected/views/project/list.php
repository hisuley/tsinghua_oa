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
						<div class="leftside" >
							<div>
								<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_lightgreen.png">
								</a>
								<a class="tittle3" href="#">统计</a>
							</div>
							
							<!--下拉选择-->
							<div >
								<div class="tittle2">
									<h2>项目列表</h2>
								</div>
								
							</div>
							<table>
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>项目类别</th>
                                        <th>编号</th>
                                        <th>项目名称</th>
                                        <th>签订日期</th>
                                        <th>项目地点</th>
                                        <th>总额（万）</th>
                                        <th>合作方我方实际合同额</th>
                                        <th>付款方式</th>
                                        <th>已款额</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
								<tbody>
                                    <?php foreach($result as $item){
                                        echo "<tr>";
                                        echo "<td>".$item->id."</td>";
                                        echo "<td>".$item->cat."</td>";
                                        echo "<td>".$item->sn."</td>";
                                        echo "<td>".$item->name."</td>";
                                        echo "<td>".date('Y-m-d', $item->sign_date)."</td>";
                                        echo "<td>".$item->location."</td>";
                                        echo "<td>".$item->total_price."</td>";
                                        echo "<td>".$item->real_contract_price."</td>";
                                        echo "<td>".$item->payment_times."次</td>";
                                        echo "<td>".$item->paid_price."</td>";
                                        echo "<td>".
                                            "<a href='".$this->createUrl('project/edit', array('id'=>$item->id))."'>编辑</a>|".
                                            "<a href='".$this->createUrl('project/delete', array('id'=>$item->id))."'>删除</a>".
                                            "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
								</tbody>

							
							</table>

							<img style="padding-left: 55px" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/tanhao.png">
							<span>现在您可以上下拖动行手动排序，系统为您保存。</span>
  							<button class="submit_button button_lightblue" type="submit">提交</button>
  						</div>
						<!--右侧选择-->
						<div class="rightside rightside_tongji" >
							<h3 style="padding-left:50px"
							>项目列表</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_leftton.png">
								<a href="#">所有项目</a>
							</div>
							<div class="menu">
								<a href="#">我管理的项目</a>
							</div>
							<img class="imgcheck" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/checkedwhite_check.png">
							<span>已完成的项目</span>

						</div>
						<div style="clear:both;float:none;"></div>
					</div>

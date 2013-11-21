<script type="text/javascript">
    $(document).ready(function(){
      $('#projectName').bind('click', function(){
        $('#projectName').val("");
      });
      $('div.radio-group>label').bind('click', function(){
        var inputId = $(this).prop('for');
        input$ = $('#'+inputId);
        input$.prop('checked', true);
        $(this).parent().find('label.checked').removeClass('checked');
        $(this).toggleClass('checked');

      });
    });
  </script>
    <div class="substance">
    <div class="leftside" >
							<a href="#">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left_blue.png">
							</a>
							<a class="tittle3" href="#">新建与申请</a>
							<form action="<?php echo $this->createUrl('project/update'); ?>" method="POST">
								<p>创建日期：<?php echo date('Y/m/d'); ?></p>
								</br>
								<input class="inputlist" id="projectName" type="text" value="添加标题">
								<label class="xuhao">序号：</label>
  								<input  class="inputlist2" type="text" />
								</br>
  								<label class="xuhao">项目类别:</label>
  								<div class="radio-group">
  									<input type="radio" name="one" value="城市规划" id="radio_cityplan"/>
	  								<label for="radio_cityplan">城市规划</label>
	  								<input type="radio" name="one" value="详规" />
	  								<label>详规</label>

  								</div>
  								
  								</br>
  								<label class="xuhao">项目编号:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">项目名称:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">签订日期:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">项目地点:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">总额（万）:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">合作我方实际合同额:</label>
  								<input  class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">付款方式:</label>
  								<div class="radio-group">
	  								<input  id="radio_one" type="radio" name="one" value="一次" />
	  								<label for="radio_one">一次</label>
	  								<input id="radio_two" type="radio" name="one" value="二次" />
	  								<label for="radio_two">二次</label>
	  								<input id="radio_three" type="radio" name="one" value="三次" />
	  								<label for="radio_three">三次</label>
	  								<input id="radio_four" type="radio" name="one" value="四次" />
	  								<label for="radio_gour">四次</label>
	  								<input id="radio_five" type="radio" name="one" value="五次" />
	  								<label for="radio_five">五次</label>
	  								<input id="radio_six" type="radio" name="one" value="六次" />
	  								<label for="radio_six">六次</label>
	  							</div>
	  							</br>
  								<label class="xuhao">一次:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">二次:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">三次:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">四次:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">五次:</label>
  								<input class="inputlist2" type="text"/>
  								</br>
  								<label class="xuhao">六次:</label>
  								<input class="inputlist2" type="text"/>
  								<button class="submit_button" type="submit">提交</button>	
							</form>
						</div>
						<!--右侧选择-->
						<div class="rightside" class="rightside_xinjianyushenqing">
							<h3>新建项目</h3>
							<div class="menu">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/arrow_left.png">
								<a href="#">项目名称</a>	
							</div>
							<div class="plusline" >
								<a href="#">
									<img class="plus"src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/plus.png"></a>	
							</div>
							<img id="tanhao" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/tanhao.png">
							<p>请先提交再创建新项目!</p>
						</div>
            <div style="clear:both;float:none;"></div>
          </div>
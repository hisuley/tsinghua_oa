				<!---工时填写栏-->
					<div class="quick_point ">
						<h3>快速点到</h3>
						<div class="quick_image">
                            <?php

                            $this->widget('ManHourWidget', array('width'=>$manhour['width']));?>
							<div>
								<a id="index-click-manhour" class="time_button"
                                   style="
                                   <?php
                                   if(!empty($manhour['start_time'])){
                                       if(empty($manhour['end_time'])){
                                           echo "background-color:red";
                                       }else{
                                           echo "background-color:green";
                                       }
                                   }
                                   ?>
                                   "
                                   href="#"
                                <?php
                                if(!empty($manhour['start_time'])){
                                    echo 'data-time="'.$manhour['total_time']['time'].'" ';
                                    echo 'data-overtime="'.$manhour['over_time']['time'].'"';
                                    if(!empty($manhour['end_time'])){
                                        echo 'data-type="stop"';
                                    }else
                                        echo 'data-type="end"';
                                }else
                                    echo 'data-type="start" data-time="0" data-overtime="0"';
                                ?>
                                >
                                <?php
                                    if(!empty($manhour['start_time'])){
                                       if(empty($manhour['end_time'])){
                                           echo "下班签到";
                                       }else{
                                           echo "签到完毕";
                                       }
                                    }else{
                                        echo "马上签到";
                                    }
                                ?>

                                </a>
							</div>
							<div class="time_text" <?php
                            if(!empty($manhour['start_time'])){
                                echo 'data-time="'.$manhour['total_time']['time'].'" ';
                                echo 'data-overtime="'.$manhour['over_time']['time'].'"';
                                if(!empty($manhour['end_time'])){
                                    echo 'data-type="start"';
                                }else
                                    echo 'data-type="end"';
                            }else
                                echo 'data-type="stop"';
                            ?>>
                                <?php
                                    if(!empty($manhour['start_time']))
                                        echo '<span class="manhour">已工作时间：'.$manhour['total_time']['hour'].'时'.$manhour['total_time']['minute'].'分'.$manhour['total_time']['second'].'秒</span><span class="overtime">加班时间：'.$manhour['over_time']['hour'].'时</span><span class="starttime">签到时间：'.date('H:i:s',$manhour['start_time']).'</span>';
                                    else
                                        echo '<span class="manhour">已工作时间：0小时0分0秒</span><span class="overtime">加班时间：0小时</span>';

                                ?>

                            </div>
                            <div style="clear:both;float:none;"></div>
                        </div>
                    </div>
                <div>
                    <a href="#" style="display:block;width:37px;height:39px;float:right;" data-type='right' class="index-go-arrow"><img class="rightgo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/right.png"></a>
                    <a href="#" style="display:block;width:37px;height:39px;float:left;" data-type='left' class="index-go-arrow"><img class="leftgo" src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/left.png"></a>
                    <div style="clear:both;float:none;"></div>
                </div>
                <div class="index-botton-container" style="height:400px;overflow:hidden;">
                    <div class="index-button-box" style="<?php if($section == 2){
                        echo 'display:none;';
                    } ?>
                        ">

                        <h3>新建与申请</h3>
                        <a href="<?php echo $this->createUrl('project/new'); ?>" class="index-common-button index-button-short index-button-skyblue	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bignewwork.png" alt=""><span>新建项目</span></a>
                        <a href="<?php echo $this->createUrl('finance/reimbursement'); ?>" class="index-common-button index-button-short index-button-skyblue	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigmoneypen.png" alt=""><span>报销申请</span></a>
                        <a href="<?php echo $this->createUrl('manhour/out'); ?>" class="index-common-button index-button-long index-button-skyblue"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigtimepen.png" alt=""><span>外出记录</span></a>
                        <a href="<?php echo $this->createUrl('leave/new'); ?>" class="index-common-button index-button-short index-button-skyblue	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//biginews.png" alt=""><span>请假申请</span></a>
                        <a href="<?php echo $this->createUrl('leave/change'); ?>" class="index-common-button index-button-short index-button-skyblue	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigcup.png" alt=""><span>调休申请</span></a>
                    </div>
                    <div class="index-button-box">
                        <h3>审批</h3>
                        <a href="<?php echo $this->createUrl('manhour/list', array('type'=>'all', 'action'=>'review')); ?>" class="index-common-button index-button-long index-button-orange	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigtimehand.png" alt=""><span>工时与加班审批</span></a>
                        <a href="<?php echo $this->createUrl('leave/list', array('type'=>Leave::NORMAL, 'action'=>'review')); ?>" class="index-common-button index-button-short index-button-orange	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigmews.png" alt=""><span>请假审批</span></a>
                        <a href="<?php echo $this->createUrl('leave/list', array('type'=>Leave::CHANGE, 'action'=>'review')); ?>" class="index-common-button index-button-short index-button-orange"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigcuphand.png" alt=""><span>调休审批</span></a>
                        <a href="<?php echo $this->createUrl('finance/reimbursementList'); ?>" class="index-common-button index-button-short index-button-orange	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigmoneyhand.png" alt=""><span>报销审批</span></a>
                        <a href="<?php echo $this->createUrl('asset/list', array('action'=>'review')); ?>" class="index-common-button index-button-short index-button-orange	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons/bigbuys.png" alt=""><span>资产申购审批</span></a>
                    </div>

                    <div class="index-button-box">
                        <h3>统计</h3>
                        <a href="<?php echo $this->createUrl('stat/manhour'); ?>" class="index-common-button index-button-long index-button-lightgreen	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigclock.png" alt=""><span>工时、加班、请假、调休统计</span></a>
                        <a href="<?php echo $this->createUrl('test/cal'); ?>" class="index-common-button index-button-long index-button-lightgreen	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigworklist.png" alt=""><span>时间节点</span></a>
                        <a href="<?php echo $this->createUrl('stat/reimbursement'); ?>" class="index-common-button index-button-short index-button-lightgreen"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigmoney.png" alt=""><span>报销统计</span></a>
                        <a href="<?php echo $this->createUrl('stat/exercise'); ?>" class="index-common-button index-button-short index-button-lightgreen	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigsporttime.png" alt=""><span>锻炼时间统计</span></a>
                    </div>

                    <div class="index-button-box" style="<?php if($section == 1){
                        echo 'margin-right:0px;';
                    } ?>">
                        <h3>固定资产</h3>
                        <a href="<?php echo $this->createUrl('asset/new'); ?>" class="index-common-button index-button-short index-button-green	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigbuy.png" alt=""><span>资产购置</span></a>
                        <a href="<?php echo $this->createUrl('asset/history'); ?>" class="index-common-button index-button-short index-button-green	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//biglist.png" alt=""><span>借用记录</span></a>
                        <a href="<?php echo $this->createUrl('asset/list'); ?>" class="index-common-button index-button-long index-button-green"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bighandborrow.png" alt=""><span>借用与归还</span></a>
                        <a href="<?php echo $this->createUrl('asset/new'); ?>" class="index-common-button index-button-long index-button-green"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons/luru.png" alt=""><span>资产录入</span></a>
                    </div>
                    <div class="index-button-box" style="margin-right:0px;<?php if($section == 1){
                        echo '';
                    } ?>">
                        <h3>个人事务</h3>
                        <a href="<?php echo $this->createUrl('user/mymanhour'); ?>" class="index-common-button index-button-short index-button-red	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigtime.png" alt=""><span>我的工时</span></a>
                        <a href="<?php echo $this->createUrl('user/exercise'); ?>" class="index-common-button index-button-short index-button-red	"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigsporttime.png" alt=""><span>锻炼时间</span></a>
                        <a href="<?php echo $this->createUrl('user/project'); ?>" class="index-common-button index-button-long index-button-red"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bigwork.png" alt=""><span>我参与的项目</span></a>
                        <a href="<?php echo $this->createUrl('user/notify'); ?>" class="index-common-button index-button-long index-button-red"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bigicons//bignews.png"><span>我的通知</span></a>
                    </div>
                    <div style="clear:both;float:none"></div>
                </div>

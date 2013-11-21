<?php

class ManhourController extends Controller{
    public function beforeAction(){
        if(Yii::app()->user->isGuest && $this->action->id != 'login'){
            $this->redirect(array('site/login', 'back'=>$this->id."/".$this->action->id));
        }
        return true;
    }
	public function actionAdd(){
		if(Yii::app()->request->isAjaxRequest){

		}else{
			if(isset($_POST['ManhourForm'])){
				$manhour = new Manhour();
				$manhour->attributes = $_POST['ManhourForm'];
				if($manhour->save()){
					$this->redirect(
						array(
							'notify/success', 
							'back'=>'manhour/my', 
							'title'=>'工时添加成功',
							'content'=>'工时添加成功！'
							)
						);
				}else{
					$this->redirect(
						array('notify/failure',
							'back'=>'project/new', 
							'title'=>'添加失败', 
							'content'=>'工时添加失败，错误原因：无法保存数据。请联系管理员。'
							)
						);
				}
			}else{
				$this->render('new');
			}
		}
	}

    /**
     * 编辑工时数据
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id){
		/**
		 * Different Roles have different method to change
		 * 
		 * */
		if(isset($id)){
			if(isset($_POST['ManhourForm'])){
                $model = Manhour::model()->findByPk($id);
                $model->start_time = strtotime($_POST['ManhourForm']['start_time']);
                $model->end_time = strtotime($_POST['ManhourForm']['end_time']);
                $model->reviewer_id = Yii::app()->user->id;
                $model->status = 'complete';
                if($model->save()){
                    $this->redirect(array('notify/success', 'back'=>'manhour/list', 'content'=>'工时数据修改成功。'));
                }else{
                    throw new CHttpException(500, '服务器错误，请通知管理员并重试。');
                }
			}else{
				//Query the manhour info from database
				$manhour = Manhour::model()->findByPk($id);
                if($manhour->type == Manhour::TYPE_OUT){
                    $this->actionOut($id);
                }
				if(empty($manhour)){
					throw new CHttpException(404,'无法找到该工时信息，是否已经删除？');
				}//Can't find the id
				else{
					$userRole = Yii::app()->user->role;

					if($userRole == 'project-manager'){
						if(Project::isUserInProject(Yii::app()->user->id, $manhour->user_id)){
                            $this->render('edit', array('result'=>$manhour));
                        }else{
                            throw new CHttpException(401, '未经许可的访问，请确认你拥有访问该资源的权限');
                        }
					}
					elseif($userRole == 'admin' || $userRole == 'superintent'){
                        $this->render('edit', array('result'=>$manhour));
					}elseif($userRole == 'manager'){
                        $this->render('edit', array('result'=>$manhour));
					}
					elseif($userRole == 'staff'){
                        if($manhour->user_id == Yii::app()->user->id){
                            $this->render('edit', array('result'=>$manhour));
                        }
                        throw new CHttpException(401, '未经许可的访问，请确认你拥有访问该资源的权限');
					}
				}
				
			}//EOF Query Data of Specific Manhour Record.
			
		}else{
			throw new CHttpException(404, '没有提供工时id，请从系统页面进入。');
		}

	}
    public function actionReport(){

    }
	public function actionDelete($id){
        if(isset($id)){
            $manhour = Manhour::model()->findByPk($id);
            $manhour->delete();
            $this->redirect(array('notify/success', 'back'=>'manhour/list', 'content'=>'删除成功。'));
        }
	}
	public function actionCounting(){
		if($_POST['ajax'] && $_POST['type']){
			// $userId = Yii::app()->user->id;
			// $manhour = new Manhou();
			$manhour = Manhour::model()->find('user_id = :user_id AND type = "normal" AND start_time > '.strtotime(date('Y-m-d')).' AND start_time < '.strtotime(date('Y-m-d').'+1 day'), array(
					':user_id' => Yii::app()->user->id
				));
			if(!$manhour){
				$manhour = new Manhour();
				$manhour->user_id = Yii::app()->user->id;
				$manhour->start_time = time();
				$manhour->create_time = time();
				$manhour->status = 'start';
				$manhour->type = 'normal';
				if($manhour->save()){
					echo 'success';
				}
			}else{
				if(empty($manhour->end_time) && $_POST['type'] == 'end'){
					$manhour->end_time = time();
                    $manhour->status = 'end';
					$manhour->save();
					echo 'end saved';
				}else{
					echo 'already saved';

				}
				
			}
		}
	}
	public function actionOut($id = false){
        if(!$id){
            if(isset($_POST['ManhourForm'])){
                $manhour = new Manhour();
                $manhour->end_time = $_POST['ManhourForm']['end_time']*3600;
                $manhour->start_time = 0;
                $manhour->create_time = time();
                $manhour->user_id = Yii::app()->user->id;
                $manhour->type = 'out';
                $manhour->status = 'end';
                $manhour->notes = $_POST['ManhourForm']['notes'];
                if($manhour->save()){
                    $this->redirect(
                        array('notify/success',
                            'back'=>'manhour/list',
                            'title'=>'外出情况已经记录',
                            'content'=>'您已经将外出情况记录到系统内。'
                        )
                    );
                }else{
                    throw new CHttpException(500, '内部服务器错误。');
                }

            }
        }else{
            $manhour = Manhour::model()->findByPk($id);
            if(isset($_POST['ManhourForm'])){

                $manhour->attributes = $_POST['ManhourForm'];
                $manhour->end_time = $manhour->end_time*3600;
                if($manhour->save()){
                    $this->redirect(
                        array('notify/success',
                            'back'=>'manhour/list',
                            'title'=>'外出情况修改成功',
                            'content'=>'您已经将外出记录到系统内。'
                        )
                    );
                }
                throw new CHttpException(500, '内部服务器错误。');
            }else{
                $this->render('out', array('result'=>$manhour));
            }
        }
        $this->render('out');
		
	}

    public function actionList(){
        $result = Manhour::getManhourList(Yii::app()->user->id, Yii::app()->user->role);
        $this->render('list', array('result'=>$result));
    }

	public function actionReviewList(){
        $userRole = Yii::app()->user->role;
        if($userRole == 'project-manager'){
            $projectResult = Project::findAll('user_id = :user_id', array(':user_id' => Yii::app()->user->id));
            $users = array();
            foreach($projectResult as $project){
                foreach($project->users as $user){//TODO add relations to project model
                    array_push($users, $user->user_id);
                }
            }
            $criteria = new CDbCriteria();
            $criteria->addInCondition('user_id', $users);
            $criteria->addInCondition('status', array('start', 'end'));
            $result = Manhour::model()->findAll($criteria);
        }elseif($userRole == 'admin'){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('status', array('start', 'end'));
            $result = Manhour::model()->findAll($criteria);
        }elseif(in_array($userRole, array('manager, superintendent'))){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('status', array('start', 'end'));
            $result = Manhour::model()->findAll($criteria);
        }
		$this->render('review', array('result'=>$result));
	}
    public function actionReview($id){
        if(Yii::app()->request->isAjaxRequest && isset($_POST['ManhourForm'])){
            $manhour = Manhour::model()->findByPk($id);
            $manhour->status = 'complete';
            $manhour->is_review = 1;
            $manhour->reviewer_id = Yii::app()->user->id;
            $manhour->save();
            echo "success";
        }else{
            if(Manhour::setReview($id, Yii::app()->user->id)){
                $this->redirect(array('notify/success', 'back'=>'manhour/list', 'content'=>'审核成功。'));
            }
        }
    }

	
}
?>
<?php
/**
 * @author Suley(dearsuley@gmail.com)
 * @version 1.0
 * @attribute
 *        cat tinyint(2)
 *        sn  varchar(100)
 *        name varchar(255)
 *        user_id int Who manages this project
 *        sign_date  int
 *        location char(255)
 *        total_price    decimal(10,2)
 *        real_contract_price decimal(10,2)
 *        payment_times    tinyint(2)
 *        first_pay    decimal(10,2)
 *      first_pay_time int
 *        second_pay    decimal(10,2)
 *        ...
 *        sixth_pay    decimal(10,2)
 *        create_time int
 *
 * */

class ProjectController extends Controller
{
    public function beforeAction(){
        if(Yii::app()->user->isGuest && $this->action->id != 'login'){
            $this->redirect(array('site/login', 'back'=>$this->id."/".$this->action->id));
        }
        return true;
    }
    public function actionNew()
    {
        $project = new Project();
        if (!in_array(Yii::app()->user->role, array('admin', 'superintendent', 'project-manager', 'manager'))) {
            $this->redirect(array('notify/failure', 'back' => 'site/index', 'content' => '您无权执行此操作。'));
        }
        if (isset($_POST['ProjectForm'])) {
            $project->attributes = $_POST['ProjectForm'];
            $project->create_time = time();
            $project = Project::format($project);
            $project->user_id = Yii::app()->user->id;
            if ($project->save()) {
                if (isset($_POST['ProjectUserForm'])) {
                    foreach ($_POST['ProjectUserForm'] as $projectUserForm) {
                        $projectUser = new ProjectUser();
                        $projectUser->attributes = $projectUserForm;
                        $projectUser->project_id = $project->id;
                        $projectUser->create_time = strtotime('now');
                        $projectUser = ProjectUser::format($projectUser);
                        $projectUser->save();
                    }
                }
                $this->redirect(
                    array('notify/success',
                        'back' => 'project/list',
                        'title' => '项目添加成功',
                        'content' => '您已经将项目添加到数据库内，5秒中后将转到项目列表页面。'
                    )
                );
            } else {
                $this->redirect(
                    array('notify/failure',
                        'back' => 'project/new',
                        'title' => '添加失败',
                        'content' => '项目添加失败，错误原因：无法保存数据。请联系管理员。'
                    )
                );
            }

        } else {
            $this->render('new');
        }
    }

    public function actionList()
    {
        $result = Project::getProjectList(Yii::app()->user->role, Yii::app()->user->id);
        $result = Project::batchReform($result);
        $this->render('list', array('result' => $result));
    }

    public function actionEdit($id = 0)
    {
        if ($id) {
            if (isset($_POST['ProjectForm'])) {
                $project = Project::model()->findByPk($id);
                $project->attributes = $_POST['ProjectForm'];
                $project = Project::format($project);
                $project->save();
                ProjectUser::model()->deleteAll('project_id = :project_id', array(':project_id' => $id));
                if (isset($_POST['ProjectUserForm'])) {
                    foreach ($_POST['ProjectUserForm'] as $projectUserForm) {
                        $projectUser = new ProjectUser();
                        $projectUser->attributes = $projectUserForm;
                        $projectUser->project_id = $id;
                        $projectUser->create_time = strtotime('now');
                        $projectUser = ProjectUser::format($projectUser);
                        $projectUser->save();
                    }
                }

                $this->redirect(array('notify/success', 'back' => 'project/list', 'content' => '编辑项目成功！'));
            } else {
                $result = Project::model()->findByPk($id);
                $this->render('new', array('result' => $result));
            }

        } else {
            throw new CHttpException(404, '您请求的数据有误，请检查来源。');
        }
    }
    public function actionDelete($id){
        if(!empty($id)){
            Project::model()->deleteByPk($id);
            $this->redirect(array('notify/success', 'back' => 'project/list', 'content' => '删除项目成功！'));
        }
    }

    public function actionReview($id = 0)
    {
        if (!$id) {
            $result = Project::model()->findByPk($id);
            if (isset($_POST['ProjectForm'])) {
                $result->attributes = $_POST['ProjectForm'];
                if (Yii::app()->request->isAjaxRequest) {
                    echo $result->save() ? 'success' : 'failure';
                } else {
                    if ($result->save()) {
                        $this->redirect(array('notify/success', 'back' => 'project/list', 'content' => '审核成功！'));
                    } else {
                        $this->redirect(
                            array('notify/failure',
                                'back' => 'project/new',
                                'title' => '审核失败',
                                'content' => '项目审核失败，错误原因：无法保存数据。请联系管理员。'
                            )
                        );
                    }
                }
            } else {
                $this->render('review', '');
            }

        }

    }
}

?>
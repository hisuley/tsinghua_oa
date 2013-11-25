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
    public function actionNew()
    {
        $project = new Project();
        if (!in_array(Yii::app()->user->role, array('admin', 'superintendent', 'project-manager', 'manager'))) {
            $this->redirect(array('notify/failure', 'back' => 'site/index', 'content' => '您无权执行此操作。'));
        }
        if (isset($_POST['ProjectForm'])) {
            $data = $_POST['ProjectForm'];
            $data['user_id'] = Yii::app()->user->id;
            if(empty($_POST['ProjectUserForm']))
                $userData = $_POST['ProjectUserForm'];
            else
                $userData = array();
            if (Project::addNew($data, $userData)){
                $this->redirect(
                    array('notify/success',
                        'back' => 'project/list',
                        'title' => '项目添加成功',
                        'content' => '您已经将项目添加到数据库内，5秒中后将转到项目列表页面。'
                    )
                );
            } else {
                throw new CHttpException(500, '无法保存数据。');
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
                $data = $_POST['ProjectForm'];
                $userData = $_POST['ProjectUserForm'];
                if(Project::updateInfo($data, $userData)){
                    $this->redirect(array('notify/success', 'back' => 'project/list', 'content' => '编辑项目成功！'));
                }else{
                    throw new CHttpException(500, '编辑项目保存失败。');
                }
                
                
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
            if(Project::deleteRelated($id)){
                $this->redirect(array('notify/success', 'back' => 'project/list', 'content' => '删除项目成功！'));
            }else{
                throw new CHttpException(500, '无法删除项目。');
            }

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
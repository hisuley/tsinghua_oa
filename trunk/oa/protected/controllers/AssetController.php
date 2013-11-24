<?php
/**
 * The asset management controller
 * @author Suley <dearsuley@gmail.com>
 * @version 1.0 11/25/13 00:39:05
 * @copyright © Beijing Backpacker Information Consulting Center
 **/
class AssetController extends Controller{
    public function beforeAction(){
        parent::beforeAction();
    }
    /**
     * Add new asset record
     * @version 1.0 11/24/13 22:43:08
     **/
	public function actionNew(){
        if(isset($_POST['AssetForm'])){
            if(Asset::addNew($_POST['AssetForm'])){
                $this->redirect(array('notify/success', 'back'=>'asset/list', 'content'=>'资产添加成功！'));
            }else{
                throw new CHttpException(500, '服务器错误，无法保存数据，请联系管理员。');
            }
        }
		$this->render('add');
	}
    /**
     * Edit the asset data
     * @version 1.0 11/24/13 22:41:24
     * @param int $id the asset record's id
     **/
    public function actionEdit($id){
        if(!empty($id)){
            $result = Asset::model()->findByPk($id);
            $this->render('add', array('result'=>$result));
        }else
            throw new CHttpException(404, '无效资产id，请检查链接来源。');
    }
    public function actionDelete($id){
        Asset::model()->deleteByPk($id);
        AssetHistory::model()->deleteAllByAttributes(array('asset_id'=>$id));
        $this->redirect(array('notify/success', 'back'=>'asset/list', 'content'=>'删除成功'));
    }
	public function actionList(){
        $result = Asset::model()->findAll();
		$this->render('list', array('result'=>$result));
	}
	public function actionBorrow($id){
        if(isset($_POST['AssetHistoryForm'])){
            $result = Asset::borrow($_POST['AssetHistoryForm']);
            if($result){
                $this->redirect(array('notify/success', 'back'=>'asset/list', 'content'=>'借出成功！'));
            }else{
                throw new CHttpException(500, '服务器错误，无法保存数据，请联系管理员。');
            }
        }else{
            $result = Asset::model()->findByPk($id);
            $this->render('borrow', array('result'=>$result));
        }
	}
	public function actionBack($id){
        if(isset($id)){
            $result = Asset::returnBack($id);
            if(Yii::app()->request->isAjaxRequest){
                if($result){
                    echo 'success';
                }else{
                    echo 'failure';
                }
            }else{
                if($result){
                    $this->redirect(array('notify/success', 'back'=>'asset/list', 'content'=>'归还成功！'));
                }else{
                    throw new CHttpException(500, '服务器错误，无法保存数据，请联系管理员。');
                }

            }
        }
	}
	public function actionHistory(){
		$this->render('history', array('result'=>Asset::getHistory()));
	}
}
?>
<?php

class AssetController extends Controller{
    public function beforeAction(){
        parent::beforeAction();
    }
	public function actionNew(){
        if(isset($_POST['AssetForm'])){
            $asset = new Asset();
            $asset->attributes = $_POST['AssetForm'];
            $asset->status = 'available';
            if($asset->save()){
                $this->redirect(array('notify/success', 'back'=>'asset/list', 'content'=>'资产添加成功！'));
            }else{
                throw new CHttpException(500, '服务器错误，无法保存数据，请联系管理员。');
            }
        }
		$this->render('add');
	}
	public function actionApplyNew(){

	}
	public function actionReview($id = 0){
		if(!empty($id)){
            $result = Asset::model()->findByPk($id);
            if(isset($_POST['AssetForm'])){
                $result->id = $id;
                $result->attributes = $_POST['AssetForm'];
                if($result->save()){
                    if(Yii::app()->request->isAjaxRequest){
                        echo 'updated';
                    }else{
                        $this->redirect(array('notify/success', 'back'=>'asset/list', 'content'=>'审核成功！'));
                    }
                }
            }
            $this->render('review');
        }
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
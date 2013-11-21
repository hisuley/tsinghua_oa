<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="error_wrapper">
    <h2>Error <?php echo $code; ?></h2>
    <div class="error">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/elements/tanhao.png" alt=""/>
        <?php echo CHtml::encode($message); ?>
    </div>
</div>

<?php

use portalium\storage\Module;
use portalium\theme\widgets\ActiveForm;
use portalium\theme\widgets\Button;
use portalium\theme\widgets\Modal;
use portalium\theme\widgets\Html;
use yii\helpers\ArrayHelper;
use portalium\storage\models\StorageDirectory;

/* @var $this yii\web\View */
/* @var $model portalium\storage\models\Storage */
/* @var $form yii\widgets\ActiveForm */

// Directory verilerini çekiyoruz
$directories = ArrayHelper::map(StorageDirectory::find()->all(), 'id_directory', 'name');

Modal::begin([
    'id' => 'uploadModal',
    'title' => Module::t('Upload File'),
    'options' => ['class' => 'fade'],
    'bodyOptions' => ['class' => 'modal-body'],
    'closeButton' => false,
    'footer' => Button::widget([
            'label' => Module::t('Close'),
            'options' => [
                'class' => 'btn btn-danger',
                'data-bs-dismiss' => 'modal',
            ],
        ]) . ' ' . Button::widget([
            'label' => Html::tag('i', '', ['class' => 'fa fa-cloud-upload-alt']) . ' ' . Module::t('Upload'),
            'encodeLabel' => false,
            'options' => [
                'class' => 'btn btn-success',
                'id' => 'uploadButton',
                'type' => 'button',
            ],
        ]),
    'dialogOptions' => ['class' => 'modal-dialog-centered'],
]);

$form = ActiveForm::begin([
    'id' => 'uploadForm',
    'action' => '/storage/default/upload-file',
    'method' => 'post',
    'options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true]
]);

echo $form->field($model, 'title')->textInput(['required' => true]);

$directories = ['0' => Module::t('Root')] + ArrayHelper::map(
        StorageDirectory::find()->all(),
        'id_directory',
        'name'
    );
echo $form->field($model, 'id_directory')->dropDownList($directories);
echo $form->field($model, 'file')->fileInput(['required' => true]);

ActiveForm::end();
Modal::end();

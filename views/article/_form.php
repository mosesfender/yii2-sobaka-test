<?php

use app\models\Article;
use app\models\Figure;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\User;
use yii\web\View;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/**
 * @var View    $this
 * @var Article $model
 * @var User    $user
 */

?>


<?php
if (!$model->figure) {
    $model->populateRelation('figure', \yii::createObject(Figure::class));
}

if (!empty($model->figure->stored_file_name)) {
    $pluginInitial = [
        'initialPreview'       => [$model->figure->getFigureUrl(true)],
        'initialPreviewAsData' => true,
        'initialCaption'       => $model->figure->original_file_name,
    ];
} else {
    $pluginInitial = [];
}

$form = ActiveForm::begin(
    [
        'layout'                 => ActiveForm::LAYOUT_DEFAULT,
        'enableClientValidation' => true,
        'enableAjaxValidation'   => false,
        'validateOnChange'       => true,
        'validateOnBlur'         => true,
        'validateOnSubmit'       => true,
    ]
);
?>

    <div class="row">
        <div class="main-data" is="article-block">
            <?= $form->field($model, 'title')->textInput() ?>
            <div class="row">
                <?= $form->field($model, 'descr', ['options' => ['class' => 'col-lg-8 col-md-6']])
                    ->textarea(['rows' => 15]) ?>
                
                <?= $form->field($model->figure, 'figureFile', ['options' => ['class' => 'col-lg-4 col-md-6']])
                    ->widget(FileInput::class, [
                        'language'      => substr(\yii::$app->language, 0, 2),
                        'pluginOptions' => ArrayHelper::merge(
                            [
                                'showClose'   => false,
                                'showUpload'  => false,
                                'browseLabel' => '',
                                'removeLabel' => '',
                                'mainClass'   => 'input-group-sm',
                            ],
                            $pluginInitial),
                        'options'       => ['multiple' => false, 'accept' => '.jpg, .png'],
                    ]) ?>
            </div>
            <?= $this->render('_lever') ?>
        </div>

        <div is="article-block-list" class="blocks-data">
            <?php
            foreach ($model->articleBlocks as $blockModel) {
                echo $this->render('_article_block', compact('blockModel', 'form'));
            }
            //end of blocks iterate ?>
        </div>

        <div class="form-buttons" is="mf-control-block">
            <?= Html::submitInput(\yii::t('app', 'Save'),
                                  ['type' => 'submit', 'class' => 'btn btn-primary btn-sm mb-2']) ?>
            <?= Html::a(\yii::t('app', 'Cancel & exit without save'), Url::to('/article/list'),
                        ['type' => 'reset', 'class' => 'btn btn-outline-secondary btn-sm']) ?>
        </div>
    </div>
<?php echo $this->render('_add-lever-main') ?>
<?php echo $this->render('_add-lever-second') ?>
<?php echo $this->render('_templates', compact('form')) ?>

<?php ActiveForm::end(); ?>
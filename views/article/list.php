<?php

use app\models\Article;
use app\models\ArticleSearch;
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\grid\GridView;
use yii\web\User;
use yii\web\View;

/**
 * @var $this  View
 * @var $user  User
 * @var $model ArticleSearch
 */


$this->title = \yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;

echo Html::beginTag('div', ['class' => 'article-list']);

echo $this->render('_list_control_block');

echo $this->render('_article_filter', compact('user', 'model'));

$hd = function ($val) {
    return $val;
};

echo GridView::widget(
    [
        'dataProvider' => $model->search(\yii::$app->request->get()),
        'columns'      => [
            [
                'format'         => 'raw',
                'contentOptions' => ['class' => 'cell-figure'],
                'value'          => function (Article $data) use (&$hd) {
                    return $data->figure ? Html::img($data->figure->getFigureUrl(true)) : '';
                }
            ],
            [
                'format' => 'raw',
                'value'  => function (Article $data) use (&$hd) {
                    return <<<HTML
                        <div class="cell-ids">
                                <label>ID: </label>
                                    <span>{$data->id}</span>
                                <label>{$hd(\yii::t('app', 'Blocks num'))}: </label>
                                    <span>{$hd(count($data->articleBlocks))}</span>
                        </div>
                        <div class="cell-title">{$data->title}</div>
                        <div class="cell-descr">{$data->descr}</div>
                        <div>
                                <label>{$hd(\yii::t('app', 'Created at'))}: </label>
                                    <span>{$hd(\yii::$app->formatter->asDatetime($data->created_at))}</span>
                                <label>{$hd(\yii::t('app', 'Updated at'))}: </label>
                                    <span>{$hd(\yii::$app->formatter->asDatetime($data->updated_at))}</span>
                        </div>
                        HTML;
                }
            ],
            [
                'format'         => 'raw',
                'contentOptions' => ['class' => 'cell-lever'],
                'value'          => function (Article $data) use (&$hd, &$user) {
                    $result = $user->can('readPost')
                        ? Html::a('', Url::to('/article/read/' . $data->id),
                                  [
                                      'class'             => 'btn btn-outline-default cmd-view',
                                      'title'             => \yii::t('app', 'Read post'),
                                      'data-bs-toggle'    => 'tooltip',
                                      'data-bs-placement' => 'left',
                                  ])
                        : '';
                    $result .= $user->can('updatePost')
                        ? Html::a('',
                                  Url::to('/article/edit/' . $data->id), [
                                      'class'             => 'btn btn-outline-default cmd-edit',
                                      'title'             => \yii::t('app',
                                                                     'Update post'),
                                      'data-bs-toggle'    => 'tooltip',
                                      'data-bs-placement' => 'left',
                                  ])
                        : '';
                    $result .= $user->can('deletePost')
                        ? Html::a('', Url::to('/article/delete/' . $data->id),
                                  [
                                      'class'             => 'btn btn-outline-default cmd-delete',
                                      'title'             => \yii::t('app',
                                                                     'Delete post'),
                                      'data-bs-toggle'    => 'tooltip',
                                      'data-bs-placement' => 'left',
                                  ])
                        : '';
                    return $result;
                }
            ]
        ]
    ]
);

echo Html::endTag('div');

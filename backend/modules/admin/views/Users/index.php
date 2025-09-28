<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\LinkPager;

/** @var $dataProvider yii\data\ActiveDataProvider
 * @var yii\web\View $this
 */
$this->title = 'Manage Users Accounts';
?>
<div class="users-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create User Account', ['create'], ['class' => 'btn btn-success']) ?></p>

    <form class="row g-3 mb-3" method="get" action="<?= Url::to(['index']) ?>">
        <div class="col-auto">
            <input type="text" name="username" value="<?= Html::encode($search) ?>"
                class="form-control form-control-sm"
                placeholder="Tìm theo Username">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-success">
                <i class="bi bi-search"></i> Tìm kiếm
            </button>
        </div>

        <p>
            <?= \yii\helpers\Html::a('📧 Test Mail', ['users/test-mail'], [
                'class' => 'btn btn-primary',
                'data-method' => 'post'
            ]) ?>

            
        </p>

        <p>
    <button type="button" class="btn btn-primary" id="btn-test-mail">
        📧 Test Mail ok
    </button>
</p>



    </form>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'role',
                'value' => function ($model) {
                    switch ($model->role) {
                        case 0:
                            return 'Admin';
                        case 1:
                            return 'Employee';
                        case 2:
                            return 'Customer';
                        default:
                            return 'Unknown';
                    }
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y H:i'], // format date
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    $url = ['toggle-status', 'id' => $model->id];
                    $btnClass = $model->status ? 'btn btn-success btn-sm' : 'btn btn-secondary btn-sm';
                    $label = $model->status ? 'normal' : 'blocked';
                    return Html::a($label, $url, [
                        'class' => $btnClass,
                        'data-method' => 'post',
                        'title' => 'Chuyển trạng thái'
                    ]);
                },
            ],

            [
                'attribute' => 'password',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::button('Reset', [
                        'Users/test-mail',
                        'class' => 'btn btn-warning btn-sm',
                        'data-method' => 'post',
                        'data-id' => $model->id,
                        'data-confirm' => 'Are you sure you want to reset the password for this user?',
                    ]);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'tableOptions' => ['class' => 'table table-bordered table-striped'],
        'pager' => [
            'class' => \yii\widgets\LinkPager::class,
            'options' => ['class' => 'pagination justify-content-center'],
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'prevPageLabel' => '&laquo;',
            'nextPageLabel' => '&raquo;',
            'disabledListItemSubTagOptions' => ['class' => 'page-link disabled'],
        ],
    ]) ?>

</div>
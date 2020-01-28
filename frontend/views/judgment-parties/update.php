<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\JudgmentParties */

$this->title = 'Appellant & Respondant Names';
/*$this->params['breadcrumbs'][] = ['label' => 'Judgment Parties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->judgment_party_id, 'url' => ['view', 'id' => $model->judgment_party_id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="judgment-parties-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

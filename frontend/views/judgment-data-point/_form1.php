<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\JudgmentElement;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

$this->params['breadcrumbs'][] = ['label' => 'Judgment Allocated', 'url' => ['judgment-mast/index']];
?>
<?php
    $jcode  = '';
   
if($_GET)
{
     $jcode = $_GET['jcode']; 
   
   
}
?>
<table>
<?php
$j_elements = JudgmentElement::find('element_name,element_text')->where(['judgment_code'=>$jcode])->all();
// echo "<pre>";
// print_r($j_elements); die;
$j=0;
foreach($j_elements as $jud_element){

?>

    <tr>
        <td><input type="hidden" id="element" value="<?= $jud_element->id; ?>"><?= $jud_element->element_name; ?><span> &nbsp;&nbsp;: &nbsp;&nbsp;</span></td> 
        <td><?= $jud_element->element_text; ?></td>
        <td><input type="text" id="<?= "weight_perc".$j ?>" value="<?= $jud_element->weight_perc; ?>"></td>
    </tr>
    
<?php $j++; } ?>
</table>
<div class="judgment-data-point-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div id="test_div"></div>


   <!--  <div class="">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Information</h4></div> -->
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 100, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $models[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'element_code',
                    'data_point',
                    'weight_perc',
                    
                ],
            ]); ?>

  <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($models as $i => $modelAddress): ?>
                <div class="item panel panel-defaultt"><!-- widgetBody -->
                  <div class="clearfix"></div>
                    <div class="panel-body" style="padding: 0px;">
                        <?php
                            // necessary for update action.
                            if (! $modelAddress->isNewRecord) {
                                echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                            }
                          $element  =  ArrayHelper::map(JudgmentElement::find()->where('judgment_code = :judgment_code', [':judgment_code' => $jcode])->all(),'element_code','element_name');
                            ?>
        <div class="row">
               <div class="col-sm-3">
                <?= $form->field($modelAddress, "[{$i}]element_code")->dropDownList($element,['prompt'=>'','class'=>'form-control-dp','ajax'=>[
                                           'type'=>'GET',
                                           'id'=>'$(this).val()',
                                           'url'=>'/advanced_yii/judgment-data-point/dp?id=+id',]])->label('Element Name'); ?>
                </div>
                <div class="col-sm-3">
                  <?= $form->field($modelAddress, "[{$i}]data_point",['inputOptions' => [
'autocomplete' => 'off']])->textInput(['maxlength' => true]) ?>    
                </div>
                <div class="col-sm-2">
                    <?= $form->field($modelAddress, "[{$i}]weight_perc",['inputOptions' => [
'autocomplete' => 'off']])->textInput() ?>
                </div>
                 <div class="col-sm-1">
                                <label>Total %</label>
                                <input type="text" name="" value="">
                                 
                             </div>
               <div class="col-sm-3" style="margin-top: 25px;">
                 <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button> <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
               </div>
        </div><!-- .row -->
      
                    </div>
                </div>
            <?php endforeach; ?>
  </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    <!-- </div> -->

    <div class="form-group">
        <?= Html::submitButton($modelAddress->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary','id'=>'test']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>  
<!-- <script type="text/javascript">
   
    $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
       $('.form-control-dp').on('change', function() {
            
           var ids = $(this).attr("id");
            var id = $(this).val();
            //console.log('IDS',ids);


        });

});
</script> -->
<!-- <script type="text/javascript">
    $(document).ready(function(){
       var field = 0;
       $(document).on('blur', '.perc', function(){
       //$(".perc").on('blur', function() {
        var owp = document.getElementById('weight_perc'+field).value;
        var element = document.getElementById('element').value;
        var selement = document.getElementById('judgmentdatapoint-0-element_code').value;
        //console.log(selement);
                var total= 0;
                $(".perc").each(function(){
                    var inputval= $(this).val();
                    if($.isNumeric(inputval)){
                        total +=parseFloat(inputval);
                    }
                        });
              if(owp >= total){
                console.log("true");
              }else{
                console.log("false");
              }
       
       });
});
</script> -->

<script>
  $(document).ready(function(){
    $(document).on('change', '.form-control-dp', function(){
       var ids = $(this).attr("id");
       var split = ids.split("element_code");
       var getstaticid = "#"+split[0];
       var wight_c = "weight"+$(this).val();
       var datapoint_c = "datapoint"+$(this).val();
       var judgment_weight = getstaticid+'weight_perc';
       var judgment_datapoint = getstaticid+'data_point';
       console.log(judgment_datapoint);
        $(judgment_weight).addClass(wight_c);
        $(judgment_datapoint).addClass(datapoint_c);
        });
    });
</script>

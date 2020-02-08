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
$count = JudgmentElement::find('element_name,element_text')->where(['judgment_code'=>$jcode])->count();

// echo "<pre>";
// print_r($count); die;
$j=0;

foreach($j_elements as $jud_element){

?>

    <tr>
        <td><input type="hidden" id="<?= "element".$j ?>" value="<?= $jud_element->element_name; ?>"><?= $jud_element->element_name; ?><span> &nbsp;&nbsp;: &nbsp;&nbsp;</span></td> 
        <td><?= $jud_element->element_text; ?></td>
        <td><input type="hidden" id="<?= "weight_perc".$j ?>" class="weight_perc" value="<?= $jud_element->weight_perc."-".$jud_element->element_name; ?>"></td>
    </tr>
    
<?php $j++; } ?>
<input type="hidden" id="count" value="<?= $count; ?>">
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
    <?php $count_row = count($models); 
    if($count_row == '1'){
    ?>
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
'autocomplete' => 'off']])->textInput(['maxlength' => true, 'onblur' => "checkslug(this.id)"]) ?>    
                </div>
                <div class="col-sm-2">
                    <?= $form->field($modelAddress, "[{$i}]weight_perc",['inputOptions' => [
'autocomplete' => 'off']])->textInput(['onblur'=> "match(this.id)"]) ?>
                </div>
                <!--  <div class="col-sm-1">
                                <label>Total %</label>
                                <input type="text"  name="" value="">
                                 
                             </div> -->
               <div class="col-sm-3" style="margin-top: 25px;">
                 <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button> <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
               </div>
        </div><!-- .row -->
      
                    </div>
                </div>
            <?php endforeach;   } else {  ?>
               <?php foreach ($models as $i => $modelAddress):  ?>
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
'autocomplete' => 'off']])->textInput(['maxlength' => true, 'onblur' => "checkslug(this.id)"]) ?> 

                </div>
                <div class="col-sm-2">


                  <?php  $ele_name = $modelAddress->element_name ;
                  if($ele_name == 'FACTS') { 
                   echo $form->field($modelAddress, "[{$i}]weight_perc",['inputOptions' => [
'autocomplete' => 'off','class' => 'weight1']])->textInput(['onblur'=> "match(this.id)"]);
}else if($ele_name == 'RULING'){ 
  echo  $form->field($modelAddress, "[{$i}]weight_perc",['inputOptions' => [
'autocomplete' => 'off','class' => 'weight2']])->textInput(['onblur'=> "match(this.id)"]); 
 }else if($ele_name == 'LEGAL ISSUES'){ 
  echo  $form->field($modelAddress, "[{$i}]weight_perc",['inputOptions' => [
'autocomplete' => 'off','class' => 'weight3']])->textInput(['onblur'=> "match(this.id)"]); 
  }else if($ele_name == 'ARGUMENTS'){ 
  echo  $form->field($modelAddress, "[{$i}]weight_perc",['inputOptions' => [
'autocomplete' => 'off','class' => 'weight4']])->textInput(['onblur'=> "match(this.id)"]); 
  }else if($ele_name == 'EVIDENCE'){ 
  echo  $form->field($modelAddress, "[{$i}]weight_perc",['inputOptions' => [
'autocomplete' => 'off','class' => 'weight5']])->textInput(['onblur'=> "match(this.id)"]); 
  }else if($ele_name == 'CONCLUSION'){ 
  echo  $form->field($modelAddress, "[{$i}]weight_perc",['inputOptions' => [
'autocomplete' => 'off','class' => 'weight6']])->textInput(['onblur'=> "match(this.id)"]);
}else{ 
  echo  $form->field($modelAddress, "[{$i}]weight_perc",['inputOptions' => [
'autocomplete' => 'off','class' => '.none']])->textInput(['onblur'=> "match(this.id)"]);  
} ?>

                </div>
                <!--  <div class="col-sm-1">
                                <label>Total %</label>
                                <input type="text"  name="" value="">
                                 
                             </div> -->
               <div class="col-sm-3" style="margin-top: 25px;">
                 <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button> <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
               </div>
        </div><!-- .row -->
      
                    </div>
                </div>
            <?php endforeach;  } ?>

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

<script>
  $(document).ready(function(){
    $(document).on('change', '.form-control-dp', function(){
       var idr = "#"+$(this).attr("id"); 
       var ids = $(this).attr("id"); 
          //judgmentdatapoint-0-weight_perc
          //judgmentdatapoint-0-data_point
       var split = ids.split("element_code");
       var getstaticid = "#"+split[0];
       var removecls = getstaticid+"weight_perc";
       var removecld = getstaticid+"data_point";
           $(removecls).removeClass("weight1");
           $(removecld).removeClass("datapoint1");
           $(removecls).removeClass("weight2");
           $(removecld).removeClass("datapoint2");
           $(removecls).removeClass("weight3");
           $(removecld).removeClass("datapoint3");
           $(removecls).removeClass("weight4");
           $(removecld).removeClass("datapoint4");
           $(removecls).removeClass("weight5");
           $(removecld).removeClass("datapoint5");
           $(removecls).removeClass("weight6");
           $(removecld).removeClass("datapoint6");
       var wight_c = "weight"+$(this).val();
       var datapoint_c = "datapoint"+$(this).val();
       var judgment_weight = getstaticid+'weight_perc';
       var judgment_datapoint = getstaticid+'data_point';
            $(judgment_weight).addClass(wight_c);
            $(judgment_datapoint).addClass(datapoint_c);
        });
    });
</script>



<script>
function match(id){
    var count = document.getElementById('count').value;
      for(var t=0; t<count ;t++){
          var name_id= "weight_perc"+t;
          var element = "element"+t;
          var nandweig = document.getElementById(name_id).value;
          var name = document.getElementById(element).value;
          var split = nandweig.split("-");
          var ele_id = split[1];
          var ele_weight = split[0];
      if(ele_id=="FACTS" && ele_weight != ''){
      var total= 0;
      var k =0;
          $(".weight1").each(function(){
          var inputval= $(this).val();
              if($.isNumeric(inputval)){
              total +=parseFloat(inputval);
              }
              if(ele_weight >= total){
              true;
              }else{
              var minus = n-1;
              var thisid = "#judgmentdatapoint-"+n+"-weight_perc";
              $(this).val(""); 
              confirm("FACTS weightage should be less than or equal "+ele_weight);
              }
              k++;});
      }else if(ele_id=="RULING" && ele_weight != ''){
      var total2= 0;
      var k =0;
              $(".weight2").each(function(){
              var inputval= $(this).val();
              if($.isNumeric(inputval)){
              total2 +=parseFloat(inputval);
              }   
              if(ele_weight >= total2){
              true;
              }else{
              var minus = n-1;
              var thisid = "#judgmentdatapoint-"+n+"-weight_perc";
              $(this).val(""); 
              confirm("RULING weightage should be less than or equal "+ele_weight);
              }
              k++;});
      }else if(ele_id == 'LEGAL ISSUES' && ele_weight != ''){
      var total3= 0;
      var n =0;
              $(".weight3").each(function(){
              var inputval= $(this).val();
              if($.isNumeric(inputval)){
              total3 +=parseFloat(inputval);
              }   
              if(ele_weight >= total3){
              true;
              }else{
              var minus = n-1;
              var thisid = "#judgmentdatapoint-"+n+"-weight_perc";
              $(this).val(""); 
              confirm("LEGAL ISSUES weightage should be less than or equal "+ele_weight);
              }
              n++;});
      }else if(ele_id == "ARGUMENTS" && ele_weight != ''){
      var total4= 0;
      var n =0;
              $(".weight4").each(function(){
              var inputval= $(this).val();
              if($.isNumeric(inputval)){
              total4 +=parseFloat(inputval);
              }
              if(ele_weight >= total4){
              true;
              }else{
              var minus = n-1;
              var thisid = "#judgmentdatapoint-"+n+"-weight_perc";
              $(this).val(""); 
               confirm("ARGUMENTS weightage should be less than or equal "+ele_weight);
              }
              n++;});

      }else if(ele_id == "EVIDENCE" && ele_weight != ''){
      var total5= 0;
      var n =0;
              $(".weight5").each(function(){
              var inputval= $(this).val();
              if($.isNumeric(inputval)){
              total5 +=parseFloat(inputval);
              }  
              if(ele_weight >= total5){
              true;
              }else{
              var minus = n-1;
              var thisid = "#judgmentdatapoint-"+n+"-weight_perc";
              $(this).val(""); 
               confirm("EVIDENCE weightage should be less than or equal "+ele_weight);
              }
              n++;});
      }else if(ele_id == "CONCLUSION" && ele_weight != ''){
      var total6= 0;
      var n =0;
              $(".weight6").each(function(){
              var inputval= $(this).val();
              if($.isNumeric(inputval)){
              total6 +=parseFloat(inputval);
              }
              if(ele_weight >= total6){
              true;
              }else{
              var minus = n-1;
              var thisid = "#judgmentdatapoint-"+n+"-weight_perc";
              $(this).val(""); 
             confirm("CONCLUSION weightage should be less than or equal "+ele_weight);
              }
              n++;});

              }
      }
}
</script>
<script>
    function checkslug(id){
      var ele_count = document.getElementById('count').value;
      var split = id.split("-");
      var count = split[1];
      var countP = count-1;
        if(count == "0"){
      var firstrow = document.getElementById("judgmentdatapoint-"+count+"-data_point").value
      var  Prevrow = "free";
      var firstelement = 'element';
      var Prevelement = 'element';
        }else{
      var firstrow = document.getElementById("judgmentdatapoint-"+count+"-data_point").value
      var  Prevrow = document.getElementById("judgmentdatapoint-"+countP+"-data_point").value
      var  firstelement = document.getElementById("judgmentdatapoint-"+count+"-element_code").value
      var  Prevelement = document.getElementById("judgmentdatapoint-"+countP+"-element_code").value
        }
        if(firstelement == Prevelement){
            if(Prevrow =="free" || firstrow != Prevrow){
                var i = count;
                  for(var k=0; k<count; k++){
                  var inputtext= document.getElementById("judgmentdatapoint-"+count+"-data_point").value;
                  var inputtext13= document.getElementById("judgmentdatapoint-"+k+"-data_point").value;
                  if(inputtext == inputtext13){
                      confirm("Data Point name Already Exist");
                      if(firstelement == '1'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '2'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '3'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '4'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '5'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '6'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }

                  }else{

                  }
                  }   true;
            }else if(Prevrow =="free" || firstrow == Prevrow){
            var i = count;
                  for(var k=0; k<count; k++){
                  var inputtext= document.getElementById("judgmentdatapoint-"+count+"-data_point").value;
                  var inputtext13= document.getElementById("judgmentdatapoint-"+k+"-data_point").value;
                  if(inputtext == inputtext13){
                      confirm("Data Point name Already Exist");
                      if(firstelement == '1'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '2'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '3'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '4'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '5'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '6'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                  }

                  }else{

                  }
                  }
            }
        }else{
        if(Prevrow =="free" || firstrow != Prevrow){
        var i = count;
                for(var k=0; k<count; k++){
                var inputtext= document.getElementById("judgmentdatapoint-"+count+"-data_point").value;
                var inputtext13= document.getElementById("judgmentdatapoint-"+k+"-data_point").value;
                if(inputtext == inputtext13){
                      confirm("Data Point name Already Exist");
                      if(firstelement == '1'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '2'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '3'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '4'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '5'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      console.log(datap);
                      }else if(firstelement == '6'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                }

                }else{

                }
                }  
        } else if(Prevrow =="free" || firstrow == Prevrow){
          var i = count;
                  for(var k=0; k<count; k++){
                  var inputtext= document.getElementById("judgmentdatapoint-"+count+"-data_point").value;
                  var inputtext13= document.getElementById("judgmentdatapoint-"+k+"-data_point").value;
                  if(inputtext == inputtext13){
                      confirm("Data Point name Already Exist");
                      if(firstelement == '1'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '2'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '3'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '4'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '5'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                      }else if(firstelement == '6'){
                      var datap= "#judgmentdatapoint-"+count+"-data_point"
                      $(datap).val("");
                  }

                  }else{

                  }
                  }
        }
        }
    }

</script>
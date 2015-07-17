<?php
  $this->pageTitle = '分配授权';
?>
<?php if($this->module->getMessage() != ""){ ?>
<div id="srbacError">
  <?php echo $this->module->getMessage();?>
</div>
<?php } ?>
<?php if($this->module->getShowHeader()) {
  $this->renderPartial($this->module->header);
}
?>
<div>
  <?php

  $tabs = array(
      'tab1'=>array(
      'title'=>Helper::translate('srbac','Users'),
      'view'=>'tabViews/roleToUser',
      ),
      'tab2'=>array(
      'title'=>Helper::translate('srbac','Roles'),
      'view'=>'tabViews/taskToRole',
      ),
      'tab3'=>array(
      'title'=>Helper::translate('srbac','Tasks'),
      'view'=>'tabViews/operationToTask',
      ),
  );
  ?>
  <div class="horTab" style="min-height:548px; margin:20px 50px 0px 50px;">
    <?php 
    Helper::publishCss($this->module->css);
    $this->widget('system.web.widgets.CTabView',
        array('tabs'=>$tabs,
        'viewData'=>array('model'=>$model,'userid'=>$userid,'message'=>$message,'data'=>$data),
        'cssFile'=>$this->module->getCssUrl(),
    ));
    ?>
  </div>
</div>

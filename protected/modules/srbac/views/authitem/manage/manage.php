<?php 
  $this->pageTitle="授权项管理"
?>
<?php if($this->module->getMessage() != ""){ ?>
<div id="srbacError">
  <?php echo $this->module->getMessage();?>
</div>
<?php } ?>
<div id="wizard" style="min-height:548px; margin:20px 50px 0px 50px;">
  <table class="srbacDataGrid" align="center">
    <tr>
      <th width="50%"><?php echo Helper::translate("srbac","Auth items");?></th>
      <th><?php echo Helper::translate('srbac','Actions')?></th>
    </tr>
    <tr>
      <td style="vertical-align: top;text-align: center">
        <div id="list">
            <?php echo $this->renderPartial('manage/list', array(
              'models'=>$models,
              'pages'=>$pages,
              'sort'=>$sort,
              )); ?>
        </div>
      </td>
      <td style="vertical-align: top;text-align: center">
        <div id="preview">

        </div>
      </td>
    </tr>
  </table>
</div>

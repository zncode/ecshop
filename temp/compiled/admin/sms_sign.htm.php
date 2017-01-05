<!-- $Id: brand_list.htm 15898 2009-05-04 07:25:41Z liuhui $ -->

<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- 品牌搜索 -->
<div class="form-div">
<form  name="searchForm" method="post">   
     <?php echo $this->_var['lang']['add_sign']; ?> <input type="text" name="sms_sign" size="15" placeholder="无需添加【】" />
    <input type="hidden" name="act" size="15" value="sms_sign_add" />
    <input type="submit" value="<?php echo $this->_var['lang']['add']; ?>" class="button" />
	<?php echo $this->_var['lang']['new_default_sign']; ?>：<?php echo $this->_var['default_sign']; ?>
  </form>
</div>



<?php $_from = $this->_var['sms_sign']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sms_sign');if (count($_from)):
    foreach ($_from AS $this->_var['sms_sign']):
?>
<div class="form-div">
<form  name="searchForm" method="post">
     <?php echo $this->_var['lang']['default_sign']; ?>: <?php echo $this->_var['sms_sign']['value']; ?>
	 <?php echo $this->_var['lang']['edited']; ?>:<input type="text" name="new_sms_sign" size="15" placeholder="无需添加【】" />

    <input type="hidden" name="extend_no" size="15" value="<?php echo $this->_var['sms_sign']['key']; ?>" />
    <input type="submit" value="<?php echo $this->_var['lang']['edit']; ?>" class="button"  name="sms_sign_update"/>
    <input type="submit" value="<?php echo $this->_var['lang']['set_default_sign']; ?>" class="button"  name="sms_sign_default"/>
  </form>
</div>



<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php echo $this->fetch('pagefooter.htm'); ?>



<form method="post" action="" name="listForm">
<!-- start brand list -->
<div class="list-div" id="listDiv">





<script type="text/javascript" language="javascript">
  <!--
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  
  onload = function()
  {
      // 开始检查订单
      startCheckOrder();
  }
  
  //-->
</script>


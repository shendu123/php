<?php if (!defined('THINK_PATH')) exit(); $__FOR_START_25808__=0;$__FOR_END_25808__=$layer;for($i=$__FOR_START_25808__;$i < $__FOR_END_25808__;$i+=1){ ?><select name="region[<?php echo ($name["$i"]); ?>]" id="<?php echo ($name["$i"]); ?>" class="region valid">
		<?php if($rid[$i] == 0): ?><option value="0" selected="selected" tier="1"><?php echo ($option["$i"]); ?></option>
		<?php else: ?>
			<option tier="<?php echo ($tier); ?>" value="0"><?php echo ($option["$i"]); ?></option><?php endif; ?>
		<?php if(is_array($rMap)): foreach($rMap as $key=>$rv): if($rid[$i] == $rv['region_id']): ?><option value="<?php echo ($rv["region_id"]); ?>" selected="selected" tier="<?php echo ($tier); ?>"><?php echo ($rv["region_name"]); ?></option>
				<?php $setout = M('region')->field(array('region_id','region_name'))->where(array('parent_id'=>$rid[$i]))->select(); ?>
			<?php else: ?>
				<option tier="<?php echo ($tier); ?>" value="<?php echo ($rv["region_id"]); ?>"><?php echo ($rv["region_name"]); ?></option><?php endif; endforeach; endif; ?>
	</select>
	<?php $tier += 1; $rMap = $setout; } ?>
<script type="text/javascript">
var regionUrl = "<?php echo U('region');?>";
</script>
<script type="text/javascript" src="/Public/Js/cuitTagLib.js"></script>
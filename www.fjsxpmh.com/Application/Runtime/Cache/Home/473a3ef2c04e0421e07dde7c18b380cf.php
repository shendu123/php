<?php if (!defined('THINK_PATH')) exit(); if(is_array($hlist)): foreach($hlist as $key=>$hav): ?><ul>
	<li class="helptit"><?php echo ($hav["cname"]); ?></li>
	<?php if(is_array($hav["nlist"])): foreach($hav["nlist"] as $key=>$hbv): ?><li><a href="<?php echo U('Article/help',array('id'=>$hbv['id']));?>"><?php echo ($hbv["title"]); ?></a></li><?php endforeach; endif; ?>
</ul><?php endforeach; endif; ?>
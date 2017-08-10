<?php if (!defined('THINK_PATH')) exit();?><ul class="notice">
    <?php if(is_array($list)): foreach($list as $key=>$nv): ?><li><a target="_blank" href="<?php echo U('Article/notice_details',array('cid'=>$nv['cid'],'id'=>$nv['id']));?>"><?php echo ($nv["title"]); ?></a></li><?php endforeach; endif; ?>
</ul>
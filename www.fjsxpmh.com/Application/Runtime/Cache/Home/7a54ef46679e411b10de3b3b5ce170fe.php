<?php if (!defined('THINK_PATH')) exit();?><div class="main_b3_top">
    <?php if(is_array($chalist)): foreach($chalist as $key=>$clv): ?><a href="<?php echo U(ACTION_NAME,array('gt'=>$clv['cid']));?>"><?php echo ($clv["name"]); if(($clv["pid"]) == "0"): ?>拍卖<?php endif; ?></a>&nbsp;&gt;&gt;&nbsp;<?php endforeach; endif; ?>
    <?php if((ACTION_NAME == 'index')and($gt[6] == 'a')): ?>全部在拍列表<?php endif; ?>
    <?php if((ACTION_NAME == 'index')and($gt[6] == 'n')): ?>在拍未出价列表<?php endif; ?>
    <?php if((ACTION_NAME == 'index')and($gt[6] == 'y')): ?>在拍已出价列表<?php endif; ?>
    <?php if((ACTION_NAME == 'waitbid')): ?>即将开拍列表<?php endif; ?>
    <?php if((ACTION_NAME == 'endbid')): ?>已成交列表<?php endif; ?>
</div>
<div class="screen_box clearfix">
    <div class="titl">全部分类</div>
    <ul class="clearfix">
        <?php if(is_array($catli)): $i = 0; $__LIST__ = $catli;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cv): $mod = ($i % 2 );++$i;?><li><a <?php if(($gt["0"]) == $cv['cid']): ?>class="on"<?php endif; ?> href="<?php echo U(ACTION_NAME,array('gt'=>$cv['cid']));?>"><?php echo ($cv["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
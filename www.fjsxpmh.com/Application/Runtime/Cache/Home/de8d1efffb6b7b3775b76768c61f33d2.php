<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="edge" />

<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection"content="telephone=no, email=no" /><!--[if IE 8]><style>.ie8 .alert-circle,.ie8 .alert-footer{display:none}.ie8 .alert-box{padding-top:75px}.ie8 .alert-sec-text{top:45px}</style><![endif]-->
<title>跳转提示</title>
<style>
body {
	margin: 0;
	padding: 0;
	background: #E6EAEB;
	font-family: Arial, '微软雅黑', '宋体', sans-serif;
}
.alert-box {
	display: none;
	margin: 130px auto 0;
	padding: 10px 0px 22px;
	border-radius: 10px 10px 0 0;
	background: #FFF;
	box-shadow: 5px 9px 17px rgba(102,102,102,0.75);
	width: 80%;
	color: #FFF;
	text-align: center
}
.alert-box p {
	margin: 0
}

.alert-circle-box {
    height: 234px;
    margin: -100px auto 0;
    position: relative;
    width: 234px;
}

.alert-circle {
}
.alert-sec-circle {
	stroke-dashoffset: 0;
	stroke-dasharray: 735;
	transition: stroke-dashoffset 1s linear
}

.alert-sec-text {
    color: #000;
    font-size: 68px;
    left: 34px;
    position: absolute;
    top: 56px;
    width: 165px;
}

.alert-sec-unit {
    color: #666;
    font-size: 34px;
    left: 39px;
    position: absolute;
    top: 133px;
    width: 156px;
}
.alert-body {
	margin: 35px 0
}
.alert-head {
	color: #242424;
	font-size: 28px;
	line-height:45px;
}

.alert-head .success{ color: #619912;}
.alert-head .error{color: #ab070b;}
.alert-head img{ vertical-align: middle; margin-right: 5px;}
.alert-concent {
	margin: 25px 0 14px;
	color: #7B7B7B;
	font-size: 18px
}
.alert-concent p {
	line-height: 27px;
	padding:0 10px;
}
.alert-btn {
	display: block;
	border-radius: 10px;
	background-color: #4AB0F7;
	height: 55px;
	line-height: 55px;
	width: 50%;
	color: #FFF;
	font-size: 20px;
	text-decoration: none;
	letter-spacing: 2px;
	margin:0 auto;
}
.alert-btn:hover {
	background-color: #6BC2FF
}
</style>
</head>
<body class="ie8">
<div id="js-alert-box" class="alert-box">
	<div class="alert-circle-box">
		<svg class="alert-circle" width="234" height="234">
			<circle cx="117" cy="117" r="108" fill="#FFF" stroke="#43AEFA" stroke-width="17"></circle>
			<circle id="js-sec-circle" class="alert-sec-circle" cx="117" cy="117" r="108" fill="transparent" stroke="#F4F1F1" stroke-width="18" transform="rotate(-90 117 117)"></circle>
		</svg>
		<div class="alert-sec-unit" x="82" y="172" fill="#BDBDBD">秒</div>
		<div id="js-sec-text" class="alert-sec-text"></div>
	</div>
	<div class="alert-body">
		<div id="js-alert-head" class="alert-head">
			<?php if(isset($message)): ?><p class="success"><img src="/Public/Img/success.png">成功提示</p>
			<?php else: ?>
				<p class="error"><img src="/Public/Img/error.png">错误提示</p><?php endif; ?>
		</div>
		<div class="alert-concent">
			<?php if(isset($message)): ?><p class="success"><?php echo($message); ?></p>
			<?php else: ?>
				<p class="error"><?php echo($error); ?></p><?php endif; ?>
		</div>
		<a id="js-alert-btn" class="alert-btn" href="<?php echo($jumpUrl); ?>">立即跳转</a>
	</div>
</div>
<script type="text/javascript">
(function(){
    document.getElementById("js-alert-box").style.display = "block";
    var t = "<?php echo($waitSecond); ?>";
    var n = document.getElementById("js-sec-circle");
    document.getElementById("js-sec-text").innerHTML = t;
    var interval = setInterval(function() {
        if (0 == t){
        	clearInterval(interval);
			location.href="<?php echo($jumpUrl); ?>"+"?rand="+Math.random();
		}else {
            t -= 1;
            document.getElementById("js-sec-text").innerHTML = t;
            var e = Math.round(t / 10 * 735);
            n.style.strokeDashoffset = e - 735;
        }
    },
    1000);
})();
</script>
 
</body>
</html>
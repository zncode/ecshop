
<style type="text/css">
		body {
			font-size:14px;
			font-family: 'microsoft YaHei';
			background: #fff;
		}
		body,ul,li,dl,dt,dd,h2,p,a {
			margin:0;
			padding:0;
		}
		ul,li,dl,dt,dd {
			list-style-type:none;
		}
		a {
			cursor:pointer;
			text-decoration: none;
		}
		h2 {
			font-weight: normal;
		}
		.code-header {
			width:100%;
			height:370px;
			background: linear-gradient(left, #769cec, #154bbe);
			background: -webkit-linear-gradient(left, #769cec, #154bbe);
			background: -moz-linear-gradient(left, #769cec, #154bbe);
			background: -ms-linear-gradient(left, #769cec, #154bbe);
			background: -o-linear-gradient(left, #769cec, #154bbe);
		}
		.code-img {
			position: relative;
			width:755px;
			height:370px;
			margin:0 auto;
			background: url('images/code-img.png') no-repeat;
		}
		.code-img-btn {
			position: absolute;
			top:256px;
			left:325px;
			z-index: 2;
			display: block;
			width:150px;
			line-height:42px;
			border-radius: 5px;
			background: #e46446;
			font-size:16px;
			color:#fff;
			text-align: center;
		}
		.accredit-dl {
			width:780px;
			height:206px;
			margin:100px auto 20px;
		}
		.accredit-dl>dt {
			float:left;
			width:172px;
			margin-right:48px;
		}
		.accredit-dl>dt>img {
			width:100%;
			height:172px;
		}
		.accredit-dl>dt>label {
			display: block;
			line-height: 30px;
			font-size:16px;
			color:#252525;
			text-align: center;
		}
		.accredit-dl>dd {
			float:left;
			width:560px;
		}
		.accredit-dl>dd>h2 {
			height:36px;
			font-size:34px;
			color:#000;
		}
		.code-btn {
			height: 44px;
			margin:28px 0 15px;
		}
		.code-btn>button {
			width:178px;
			line-height: 44px;
			margin-right: 10px;
			border-radius:5px;
			background: #5da4dc;
			font-size:16px;
			color:#fff;
			text-align: center;
			border:none;
			cursor:pointer;
		}
		.code-scene {
			line-height: 20px;
			font-size:13px;
			color: #979797;
		}
		.code-icon {
			width:86px;
			height: 86px;
			margin-top:-310px;
			background: #5da4dc;
		}
		.code-icon>img {
			width:32px;
			height: 32px;
			margin:27px;
		}
	</style>

<body>
<header class="code-header">
	<section class="code-img">
		<a class="code-img-btn" href="http://yunqi.shopex.cn/products/ecshop_app?from=nav" target="_blank">立即免费体验</a>
	</section>
</header>
<dl class="accredit-dl">
	<dt>
		<img src="http://qr.wdwd.com/qr?size=350&&txt=<?php echo $this->_var['url']; ?>" alt="loading...">
		<label>扫码预览移动店铺</label>
	</dt>
	<dd>
		<h2>H5店铺二维码</h2>
		<section class="code-btn">
			<textarea cols="0" rows="0" id="siteUrl" style="width:0px;height:0px;"><?php echo $this->_var['url']; ?></textarea>
			<button class="code-apply" onclick="location='h5_setting.php?act=list'">应用配置</button><button class="code-link" onClick="copyUrl();">复制移动端店铺链接</button>
		</section>
		<p class="code-scene">适用场景：<br />
			• 将店铺地址复制黏贴至微信公众号自定义菜单，通过公众号推广；<br />
			• 将二维码印刷到名片、易拉宝等宣传物，通过线下渠道宣传吸引新客户；<br />
			• 将二维码放到您的官网主页、论坛；或者打开手中的微信、QQ，扫一扫分享给您的老客户；
		</p>
	</dd>
</dl>
<section class="code-icon"><img src="images/code-icon.png" alt="loading..."></section>
<script>
	document.getElementById("c_iframe").height = window.screen.availHeight - 120;
</script>
<script type="text/javascript">
	function copyUrl()
	{
		var Url2 = document.getElementById("siteUrl");
		Url2.select(); // 选择对象
		document.execCommand("Copy"); // 执行浏览器复制命令
		alert("复制成功,如复制失败请手动复制下面链接！\r\n<?php echo $this->_var['url']; ?>");

	}
</script>

</body>
</html>
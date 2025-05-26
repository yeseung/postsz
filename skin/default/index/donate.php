<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<div style="font-size:16px; text-align:center; padding-top:60px">여러분의 후원금으로 운영됩니다. <br /><br />
기부해주시는 모든 분들께 감사의 인사를 드리며, <br />유용한 정보로 보답하겠습니다. <br /><br /><br />
<button id="donate" title="후원하기" style="font-size:14px;">후원하기</button></div>



<script type="text/javascript"> 
//<![CDATA[ 

$(document).ready(function() { 
	
	$( "button#donate" )
		/*.button({
			text: true,
			icons: {primary: "ui-icon-cart"}
		})*/
		.click(function() {
			self.location.href = "<? echo $common_pbank_donate ?>";
			return true;
		});
	
});

//]]> 
</script>

<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<div id="disqus_thread"></div>
<script type="text/javascript">
	var disqus_config = function() {
		this.page.url = "<? echo $common_path ?>?mode=feedback";
	}
	/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	var disqus_shortname = 'postsz'; // required: replace example with your forum shortname
	/* * * DON'T EDIT BELOW THIS LINE * * */
	(function() {
		var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	})();
</script>
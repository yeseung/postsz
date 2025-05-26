<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
include_once ("skin.mobile/{$common_skin_m}/index/head.php");?>


<? //echo $_GET['user']." / ".$_GET['short'] ?> 

<?
$sql = "select left(bo_content, ".$common_content_len_m.") as bo_content from remember_board_".$_GET['user']." where bo_id = ".$_GET['id'];
$result = mysql_query($sql, $connect);
$row = mysql_fetch_array($result);
$bo_content = $row['bo_content'];
$bo_content_title = get_text_index(strip_tags($bo_content));
//echo $sql;
?>


<div data-role="page" data-theme="a" id="view">
    <div data-role="header" data-position="inline">
    	<!--<a href="javascript:history.go(-1)" data-ajax="false">Back</a>-->
        <a href="#" data-rel="back">Back</a>
        <h1><? echo get_mb_strimwidth($bo_content_title, 30) ?></h1>
    </div>
    <div style="padding:10px; background-color:#FFFFFF;">

        <div id="disqus_thread"></div>
        <script type="text/javascript">
			var disqus_config = function() {
    			this.page.url = "<? echo $common_path."process/view.sns.php?short=".$_GET['short'] ?>";
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

	</div>
</div>

<?
include_once ("skin.mobile/{$common_skin_m}/index/tail.php");
?>
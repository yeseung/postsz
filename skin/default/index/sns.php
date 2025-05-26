<?
if (!defined("_REMEMBER_")) exit; // 개별 페이지 접근 불가
?>


<div class="fb-like" data-href="<? echo $common_path ?>" data-send="true" data-width="521" data-show-faces="false"></div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ko_KR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div style="padding-bottom:5px"><a href="https://twitter.com/postsz" class="twitter-follow-button" data-show-count="true" data-lang="en" ></a></div>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];
	if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";
	fjs.parentNode.insertBefore(js,fjs);
	}}(document,"script","twitter-wjs");
</script>


<?
/*
<script src="http://widgets.twimg.com/j/2/widget.js"></script> 
<script> 
new TWTR.Widget({ 
  version: 2, 
  type: 'profile', 
  rpp: 20, 
  interval: 6000, 
  width: 'auto', 
  height: 130, 
  theme: {
    shell: {
      background: '#333333',
      color: '#ffffff'
    },
    tweets: {
      background: '#000000',
      color: '#ffffff',
      links: '#4aed05'
    }
  },
  features: { 
    scrollbar: true, 
    loop: false, 
    live: true, 
    hashtags: true, 
    timestamp: true, 
    avatars: false, 
    behavior: 'all' 
  } 
//}).render().setUser('pjy1234').start(); 
}).render().setUser('postsz').start(); 
</script>

<br />
*/
?>
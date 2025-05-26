<div style="padding:5px 8px 5px 5px">
    <form>
		<textarea name="textarea" id="textarea-a" style="height:100px;"></textarea>
        <div style="float:left; width:70%">
            <fieldset data-role="controlgroup"  data-type="horizontal" data-role="fieldcontain">
            <input type="radio" name="radio" id="radio1" checked="checked" />
            <label for="radio1"><img src="/skin.mobile/<? echo $common_skin_m ?>/img/locked.png" /></label>
            <!--<label for="radio1">private</label>-->
            <input type="radio" name="radio" id="radio2" />
            <!--<label for="radio2">public</label>-->
            <label for="radio2"><img src="/skin.mobile/<? echo $common_skin_m ?>/img/lock.png" /></label>
            <input type="hidden" id="public_checked" value="radio1" />
            </fieldset>
        </div>
		<div style="float:right; width:30%; padding-top:3px; text-align:right">
        	<input type="image" src="/skin.mobile/<? echo $common_skin_m ?>/img/postit_m.png" data-role="none" id="write_m" />
        </div>
    </form>
</div>
<br clear="all" />
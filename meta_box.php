<?php
/********************************************
*
*	Filename:	meta_box.php
*	Author:		Nguyen Ngoc Hieu
*	E-mail:		crazydesktop@gmail.com
*	Finish ver 1.1.2:		10, September, 2011
*
*********************************************/
?>
<input type="hidden" name="rd2_mtc_nonce" id="rd2_mtc_nonce" value="<?php echo $rd2_mtc_nonce ?>" />
<p>The list of tags commonly used alternative for categories. Right click to show the context menu, hit Enter when finish editing, double click on the tag to add it to the post.</p>
<iframe name="frametree" id="treetag" width="270" height="250" src="<?php echo PLUGIN_URL . "treephp/index.php";?>">
Your browser does not support "iframe" tag !
</iframe>
<p> Enter new tags into the box below. New tags can be added by a comma - ",".</p>
<textarea rows="3" cols="35" id="suggestTags" autocomplete="off" class="ac_input" ></textarea>
<p> The selected tags (List of tags you choose for the post). Click checkbox to delete tag. </p>
<ul id="rd2_mtc_tag_list" style="height: 150px; overflow: auto; border: 1px solid #dfdfdf; margin: 1em 0; padding: .5em;">

<?php foreach($all_post_tags as $tag) : 
	$datatags.=$tag->name . ",";

	if ( in_array( $tag->term_id, $assigned_ids ) ):?>
	<li>
		<input type="checkbox" value="<?php echo $tag->name; ?>" name="rd2_mtc_tags[]" id="tagged_<?php echo $tag->term_id; ?>" class="mycheckbox" checked="true" />
		<label for="tagged_<?php echo $tag->term_id; ?>"><?php echo $tag->name; ?></label>
	</li>
<?php 
	endif;
	endforeach; ?>
</ul>

 <script type="text/javascript">
	 
(function($) {

var newIDTags=0;	//ket gan ID moi cho moi checkbox
var newdatatext="";//chua du lieu moi khong co cac phan tu trung nhau trong textbox
var getdatatags = "<?= $datatags ?>";//lay danh sach cac tag tu bien PHP
getdatatags=getdatatags.split(",");
// ham trim khoang trong o 2 dau chuoi///////////////////////////////////////
String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, "");
};
//////////////////////////////////////////////////////////////////////////////
//lay du lieu cac tag duoc chon khi khi lan dau bai post nap
newdatatext="";
 $("#rd2_mtc_tag_list .mycheckbox").each(function(){  
		newdatatext=newdatatext + $(this).val() + ", ";
	});
$("#suggestTags").val(newdatatext);	
//ham duoc goi tu iframe de cap nhat du lieu chon tu treeview vao textbox
window.func_treeview_to_textbox = function () {
		var datatext2=$("#suggestTags").val().split(",");
		for(var i=0; i<datatext2.length; i++) {
			var tagstext=datatext2[i].trim();
			if (tagstext !="")
			findValueCallback("",tagstext,tagstext);
		}
};
//ham duoc goi tu iframe de lay mang du lieu cac tag
window.func_getdatatags = function () {
		return getdatatags;
};
///////////////////////////////////////////////////////////////////////	
$("#suggestTags").keyup(function(event) {
	if (event.keyCode =="188" ){//user bam dau phay
		$(this).val($(this).val()+ " ");
		var datatext=$(this).val().split(",");
			var tagstext=datatext[datatext.length-2].trim();
			if (tagstext !="")
			findValueCallback("",tagstext,tagstext);
	
	}
});
$('.mycheckbox').live('click', function () {
	//xoa checkbox va label gang kem voi no
	 $('label[for="' + $(this).attr('id') + '"]').remove();
     $(this).remove();
	 //cap nhat textbox
	 newdatatext="";
	 $("#rd2_mtc_tag_list .mycheckbox").each(function(){  
			newdatatext=newdatatext + $(this).val() + ", ";
		});
	$("#suggestTags").val(newdatatext);	
	 
});

// ham kiem tra cac tag giong nhau, tao checkbox cho moi tag moi va cung cap nhat du lieu textbox//////////////////////////
function findValueCallback(event, data, formatted) {
	var bflag =false;
	
	if (formatted.trim() !=""){
		newdatatext="";
		bflag =false;
		$("#rd2_mtc_tag_list .mycheckbox").each(function(){
			
               if ($(this).val() == formatted){
					bflag=true;
				} 
				newdatatext=newdatatext + $(this).val() + ", ";

		});
		
		if (bflag ==false){
			newIDTags=newIDTags+1;
			newdatatext=newdatatext + formatted + ", ";
			$("#rd2_mtc_tag_list").append('<li> <input type="checkbox" value="' + formatted + '" name="rd2_mtc_tags[]"  id="tagged_AddNew' + newIDTags + '" class="mycheckbox" checked="true" /> <label for="tagged_AddNew' + newIDTags + '">' + formatted + '</label> </li>'
			);
		}
		
		$("#suggestTags").val(newdatatext);
		
	}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$("#suggestTags").autocomplete(getdatatags, {
		multiple: true,
		autoFill: true,
		multipleSeparator: ", "
	});
	
	$(":text, textarea").result(findValueCallback).next().click(function() {
		$(this).prev().search();
	});
	
	
  
}) (jQuery);
</script>




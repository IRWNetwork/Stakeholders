$(document).on("click",".ellips.featured", function(){
	var id = $(this).attr('data-id');
	if($(this).find("i").hasClass("fa fa-star text-green")) {
		$(this).removeClass("active");
		$(this).find("i").removeClass("fa fa-star text-green").addClass("fa fa-star-o text-white");
		$(this).parent().find('.favorite').find('i').removeClass("fa fa-star text-green").addClass("fa fa-star-o text-white");  // remove selection from sub menu
	}
	else {
		$(this).addClass("active");
		$(this).find("i").removeClass("fa fa-star-o text-white").addClass("fa fa-star text-green");
		$(this).parent().find('.favorite').find('i').removeClass("fa fa-star-o text-white").addClass("fa fa-star text-green"); // remove selection on sub menu
	}
	favorite(id);
});

$(document).on("click",".favorite", function(){
	var id = $(this).attr('data-id');
	if($(this).find("i").hasClass("fa fa-star text-green")) {
		$(this).removeClass("active");
		$(this).find("i").removeClass("fa fa-star text-green").addClass("fa fa-star-o text-white");
		$(".featured"+id).find("i").removeClass("fa fa-star text-green").addClass("fa fa-star-o text-white"); // remove selection from main star
	}
	else {
		$(this).addClass("active");
		$(this).find("i").removeClass("fa fa-star-o text-white").addClass("fa fa-star text-green")
		$(".featured"+id).find("i").removeClass("fa fa-star-o text-white").addClass("fa fa-star text-green"); // add selection on main star
	}
	favorite(id);
});

function favorite(id){
	$.post( BASE_URL+"home/add_remove_to_favorite/",{id:id}, function( data ) {
		var obj = $.parseJSON(data);
		$(".general-msg-bar").show().text(obj.msg);
		setTimeout(function(){ 
				$(".general-msg-bar").hide().text("");
		}, 3000);
	});	
}

function response_messages(message) {
	$(".general-msg-bar").show().text(message);
	setTimeout(function(){ 
			$(".general-msg-bar").hide().text("");
	}, 3000);
}

$(document).ready(function(){
	$("#btn-create-playlist").click(function(){
		var title 		= $("#playlist_tilte").val();
		var description = $("#playlist_description").val();
		$.post( BASE_URL+"home/add_playlist/",{title:title,description:description}, function( data ) {
			var obj = $.parseJSON(data);
			$("#createPlayList").modal('hide');
			$(".general-msg-bar").show().text(obj.msg);
			setTimeout(function(){ 
					$(".general-msg-bar").hide().text("");
			}, 3000);
		});
	});
	
	$(".playlist_li").click(function(){
		var playlistid 	= $(this).attr('data-playlist-id');
		var songid 		= $(this).attr('data-song-id');
		$.post( BASE_URL+"home/add_song_to_playlist/",{playlistid:playlistid,songid:songid}, function( data ) {
			var obj = $.parseJSON(data);
			$(".add_play_list_menu_box").hide();
			$(".general-msg-bar").show().text(obj.msg);
			setTimeout(function(){ 
					$(".general-msg-bar").hide().text("");
			}, 3000);
		});
	});
	$(".item-overlay").click(function(){
		var url = $(this).attr('data-url');
		window.location = url;
	});
});

function show_code(){
	$("#embed_code").show(350);
}
	
function showSharePopup(id){
	$.post( BASE_URL+"home/showpopup/",{id:id}, function( data ) {
		$("#share_popup_detail").html( data );
	});
}
$(document).ready(function(){
	$(document).on("click",".add-play-list-btn", function(){
		$(this).parents("#contextmenu").find(".main-grid-menu").hide();
		$(this).parents("#contextmenu").find(".add_play_list_menu_box").show();
	});
	$(document).on("click",".ellips.dropdown-toggle", function(){
		$(".main-grid-menu").show();
		$(".add_play_list_menu_box").hide();
	});
	$(document).on("click",".grid__item__menu", function(e){		
		e.stopPropagation();
	});

	$(document).on("hover",".field .item", function(){
		$(".main-grid-menu").show();
		$(".add_play_list_menu_box").hide();
	});
});

function showLoginMsg(){
	$(".general-msg-bar").show().text("Please login to add in playlist");
	setTimeout(function(){ 
			$(".general-msg-bar").hide().text("");
	}, 3000);
}
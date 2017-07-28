

$( document ).ready(function() {

$('body').on('click', '#sbmt', function(){// press button to add comment

      var id_article = '';
      var page = '';
	  var now = new Date();
	  var com_text = $('#comment').val(); // text comment
	  var text_btn;
	  var obj = $(this).parent();
	  var data_parent_current = $(this).data("parent");
      var formated_date = now.getFullYear()+'-'+now.getMonth()+'-'+now.getDate()+' '+now.getHours()+':'+ now.getMinutes()+':'+ now.getSeconds(); // current time
	  if(ObjType=='PAGE')
		  page = ObjComment;
	  else 
	      id_article = ObjComment;
      $.post( PathTempl+'/add_comment.php', 
        {
            id_article: id_article, page: page, parent: $(this).data("parent"), name: UserName, text: com_text
        },
        function(data){
			
            if(data!='error'){
			   
			   if(data_parent_current){ // answer on comment
			   obj.after('<div class="com_item" ><p>'+UserName+'<br>'+formated_date+'<br>'+com_text+'<br>'+'<a class="add_com" data-parent="'+data+'" href="javascript:void()">Ответить</a></p></div>'); } 
			   else 	   // new comment
				$('.com_block').append('<div class="com_item" ><p>'+UserName+'<br>'+formated_date+'<br>'+com_text+'<br>'+'<a class="add_com" data-parent="'+data+'" href="javascript:void()">Ответить</a></p></div>');
			}
        }); 
   
        $('#comment').remove(); // delete textarea
		
		if($(this).data("parent")) // text for button add
			text_btn ='Ответить';
		else text_btn ='Добавить комментарий';
		
		$(this).before('<a class="add_com" data-parent="'+$(this).data("parent")+'" href="javascript:void()">'+text_btn+'</a>');
        $(this).remove();
  
}); 
  
	$('body').on('click', '.add_com', function(){// press button to visible textarea
		var data_parent_prev = $('#comment').next().data("parent");
		if(data_parent_prev)
			var text_btn ='Ответить';
		else var text_btn ='Добавить комментарий';
		
		$('#comment').before('<a class="add_com" data-parent="'+data_parent_prev+'" href="javascript:void()">'+text_btn+'</a>'); //  change  button add comment
		$('#comment').next().remove(); 
		$('#comment').remove(); // close open textarea
		
		$(this).text('Ответить');
		$(this).before('<textarea id="comment" name="comment" rows="5" cols="40" placeholder="Комментарий"></textarea>');
		$(this).before('<a id ="sbmt" data-parent="'+$(this).data("parent")+'" href="javascript:void()">Ответить</a>');
		$(this).remove();
		
	});	



});    
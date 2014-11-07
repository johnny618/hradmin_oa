$(function(){
    
	// 左侧功能
       
        
	//$("#actNav li .act_nav_title").toggle(
         //       function(){
           //          $(this).show();
			//$(this).find("a").click(function(){
			//var li = $(this).addClass("act_nav_titleHover").parent();
//                                
			//li.siblings().find('.act_nav_title').removeClass("act_nav_titleHover");
			//li.find('.act_nav_border').show();
			//li.siblings().find('.act_nav_border').hide();
			//li.find('.act_sub').show();
			//li.find(".act_sub p a").removeClass("act_sub_a");
			//li.siblings().find('.act_sub').hide();
             //   },
           //     function(){
                    
            //    });
        
	$("#actNav li .act_sub P").each(function(i){
		$(this).find("a").click(function(){
			$(this).addClass("act_sub_a");
                        $(this).parent().siblings().children().removeClass("act_sub_a");
			var p = $(this).parents("li");
			p.siblings().find(".act_sub P a").removeClass("act_sub_a");
		});
	});
	//我的文档
	$("#wywd tr:last").find("td p").css("border","none");
	$("#wywd tr").each(function(i){
		$(this).find("td p .mywd_a").click(function(){
			$("#wywd tr").eq(i).hide();
			});
		});
});
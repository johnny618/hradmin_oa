$(function(){
	//设置表格控制
	$(".settype_table table tr:even").find("td").css({"border-bottom-color":"1px solid #eceff1","background-color":"#fff"});
	$(".settype_table table tr:last").find("td").css("border","none");
	//新建流程
	$(".settype_newbox ul").each(function(){
		var lastLi = $(this).children().last();
		lastLi.css("border","none");
	});
	//路径设置左侧功能
	$(".road_left h4 a").each(function(i){
		this.b = true;
		$(this).click(function(){
			if (this.b){
				$(this).addClass("active");
			} else {
				$(this).removeClass("active");
			}
			this.b = !this.b;
			$(".road_sub").eq(i).toggle();
			$(".road_sub").find("a").css("color","#333");
		});
	});	
	$(".road_sub_box .road_sub_boxtitle").each(function(){
		this.b = true;
	});	
	$(".road_sub_box .road_sub_boxtitle").click(function(){
		var a = $(".road_sub_boxtitle");
		if(this.b){
			$(this).addClass('active');
			$(this).css("color","#ff5454").parent().siblings().find(a).css("color","#333");						
		}else{
			$(this).removeClass('active');
			$(this).css("color","#333");
		}
		this.b = !this.b;
		$(this).siblings().toggle();
		$(".road_sub_box ul a").css("color","#333");
		
		});	
	$(".road_sub_box ul a").click(function(){
		$(this).css("color","#ff5454").parent().siblings().find("a").css("color","#333");
		var li = $(this).parent();
		var ul = li.parent();
		var roadSubBox = ul.parent();
		var roadSub = roadSubBox.parent();
		ul.siblings().css("color","#ff5454");
		roadSubBox.siblings().find("a").css("color","#333");
		roadSub.siblings().find("a").css("color","#333");
		
	});
	//左侧关闭、展开/以及右侧宽度的改变
	$(".road_toogle a").each(function(){
		this.b = true;
		$(this).click(function(){
			if (this.b){
				$(this).addClass("active");
				$(".road_left").animate({left:'-'+$(".road_left").outerWidth(true)+'px'},500);
				$("#set_right").animate({left:12,width:document.documentElement.clientWidth - 13});
			} else {
				$(this).removeClass("active");
				$(".road_left").animate({left:0},500);
				$("#set_right").animate({left:+$(".road_left").outerWidth(true) + 12 +'px',width:document.documentElement.clientWidth - $('#road_act').outerWidth(true) - 13},500);
			}
			this.b = !this.b;
		});
	});
	//讲师申请弹出层
	$(".aut_ctsbox li a").each(function(i){
		$(this).click(function(){
                    console.info(top.window)
			heightChange();
			$(".aut_div").show();
			$(".aut_adddiv").eq(i).show();
			$(".aut_adddiv").css({
                              left:($(window).width() - $(".aut_adddiv").width())/2,
                              top:100+"px"
             },"slow");	
		});	
	});
	$(".aut_close").each(function(i){
		$(this).click(function(){
			$(".aut_adddiv").animate({top:-537},"slow",function(){
				$(".aut_adddiv").hide();
				$(".aut_div").hide();	
			});	
		});
	});
	$(".aut_justxt li").click(function(){
		$(".aut_adddiv").animate({top:0},"slow",function(){
			$(".aut_adddiv").hide();
			$(".aut_div").hide();	
		});	
	});
//	$(".aut_ddiv_nav h4").each(function(i){
//		this.b = true;
//		$(this).click(function(){
//			if (this.b){
//				$(this).addClass("active");
//				$(".aut_ddiv_sub").eq(i).show();
//			} else {
//				$(this).removeClass("active");
//				$(".aut_ddiv_sub").eq(i).hide();	
//			}
//		this.b = !this.b;
//		});	
//	});
        $(".aut_ddiv_nav h4").toggle(function () {
            $(this).addClass("active");
            $(this).siblings(".set_tree").show();
          },
          function () {
            $(this).removeClass("active");
            $(this).siblings(".set_tree").hide();
          });
        $(".aut_ddiv_subbg").toggle(function (event) {
            $(this).addClass("active");
            $(this).children("ul").show();
          },
          function (event) {
            $(this).removeClass("active");
            $(this).children("ul").hide();
          });
        $(".set_tree span").click(function(event){
            $(".set_tree span").removeClass('red');
            $(this).addClass('red');
            if (!$(this).parent().hasClass('aut_ddiv_subbg')) {
                event.stopPropagation();
            }
        });
	$(".aut_ddiv_sub h5").each(function(i){
		this.b = true;
		$(this).click(function(){
			if (this.b){
				$(this).addClass("active");
				$(".aut_ddiv_sub ul").eq(i).show();
			} else {
				$(this).removeClass("active");
				$(".aut_ddiv_sub ul").eq(i).hide();
			}
		this.b = !this.b;
		});
	});
	$(".aut_ddiv_sub ul h6").each(function(){
		this.b = true;
		$(this).click(function(){
			if (this.b){
				$(this).addClass("active");
				$(this).siblings().show();
			} else {
				$(this).removeClass("active");
				$(this).siblings().hide();
			}
		this.b = !this.b;
		});
	});
	$(".aut_people_color ul li .aut_ddiv_subbox p").each(function(){
		this.b = true;
		$(this).click(function(){
			var autSubBox = $(this).parent();
			if (this.b){
				$(this).css("color","#ff1c1c");
				autSubBox.siblings().css("color","#666");
			}	
		});
	});
	$(".aut_people_color ul li h6").each(function(){
		var h6Boolean = true;
		$(this).click(function(){
			var li = $(this).parent();
			if (h6Boolean){
				$(this).css("color","#ff1c1c");
				li.siblings().find("h6").css("color","#666");
			} else {
				$(this).css("color","#666");
				$(this).siblings().find("p").css("color","#666");
			}
		h6Boolean = !h6Boolean;
		});	
	});
});

//新建流程表单验证
function newForm(){
	var setForm = document.getElementById("setform");
	var setFormErr = setForm.getElementsByTagName("b");
	for (var i = 0; i < setFormErr.length; i++){
		if (setForm.elements[i].value == ""){
			setFormErr[i].style.display = "block";
		}
	}
}
function backForm(){
	var enterBack = confirm("确定要返回？");
	var backHref = document.getElementById("back_href");
	if (enterBack == true){
		backHref.href = "settype.html";
	} else {
		return false;
	}
}

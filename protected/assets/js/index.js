function switchTab(id){
	this.oWrap = $('#'+id);
	this.oNavBox = this.oWrap.find('.nav');
	this.iNum = 0;
	this.oNavDiv = this.oNavBox.children('div');
	this.oNavUl = this.oNavBox.find('ul');
	this.aNavLi = this.oNavUl.children('li');
	this.oLeBtn = this.oNavBox.find('.leftBtn');
	this.oRiBtn = this.oNavBox.find('.rightBtn');
	this.oContentBox = this.oWrap.find('.content');
	this.oContentDiv = this.oContentBox.find('.content-div');
	this.aDiv = this.oContentDiv.children('div');
}
switchTab.prototype.init = function(){
	this.setWidth();
}

switchTab.prototype.setWidth = function(){
	// 初始化导航宽度
	this.oNavUl.css('width',this.aNavLi.length*this.aNavLi.outerWidth(true));
	this.oNavDiv.css({
		'width':this.oNavBox.outerWidth(true),
		'height':this.oNavBox.outerHeight(true)
	});
	this.oContentDiv.css({
		'width':this.oContentBox.outerWidth(true)
	});
	this.showBtn();
	this.setActive();
}

switchTab.prototype.showBtn = function(){
	// 控制显示隐藏导航左右侧按钮
	if( this.aNavLi.outerWidth(true)*this.aNavLi.length <= this.oNavBox.outerWidth(true)){
		this.oLeBtn.hide();
		this.oRiBtn.hide();
	}else{
		this.oLeBtn.show();
		this.oRiBtn.show();
	}
	this.changeTab();

}

switchTab.prototype.setActive = function(){
	// 初始化选中状态
	var that = this;
	this.aNavLi.eq(this.iNum).addClass('active');
	this.aDiv.eq(this.iNum).show();
	this.aNavLi.click(function(){
		var iHeight = 0;
		that.aNavLi.removeClass('active');
		$(this).addClass('active');
		for( var i = 0; i < $(this).index(); i++ ){
			iHeight+= that.aDiv.eq(i).outerHeight(true)+5;
		}
		that.oContentDiv.animate({'top':-iHeight});
	});
}
switchTab.prototype.changeTab = function(){
	// 切换菜单及内容

	var that = this;
	this.oLeBtn.click(function(ev){
		if(that.iNum>0){
			that.iNum--;
		}
		that.oNavUl.animate({'left':-that.iNum*that.aNavLi.outerWidth(true)});
	});

	this.oRiBtn.click(function(ev){
		var iMax = Math.floor(that.oNavBox.outerWidth(true)/that.aNavLi.outerWidth(true));
		if( that.iNum < that.aNavLi.length - iMax ){
			that.iNum++;
		}
		that.oNavUl.animate({'left':-that.iNum*that.aNavLi.outerWidth(true)});
	});
}

function fnSwitchlc(){
	// 切换流程函数
	var oWrap = $('.lcBox');
	var oContent = oWrap.children('div');
	var oLeBtn = oWrap.children('.leftBtn');
	var oRiBtn = oWrap.children('.rightBtn');
	var oUl = oWrap.find('ul');
	var aLi = oUl.children('li');
	var iNum = 0;
	oContent.css('width',oWrap.width());
	oUl.css('width',aLi.length*aLi.outerWidth(true));

	oLeBtn.click(function(){
		if(iNum>0){
			iNum--;
		}
		oUl.animate({'left':-aLi.outerWidth(true)*iNum});
	});
	oRiBtn.click(function(){
		if(iNum < aLi.length - 4){
			iNum++;
		}
		oUl.animate({'left':-aLi.outerWidth(true)*iNum});
	});
}

function fnSwitchDeeds(){
	var oWrap = $('.scrollBox');
	var oImgUl = $('.scrollBox').find('.imgUl');// 图片ul
	var aImg = oImgUl.children('li');// 图片列表
	var oNav = oWrap.find('.s-nav');
	var oNavDiv = oNav.children('div');
	var oNavUl = oNav.find('ul');
	var aNavLi = oNavUl.children('li');
	var oLeBtn = oNav.find('.lBtn');
	var oRiBtn = oNav.find('.rBtn');
	var iNum = 0;
	var iNum2= 0;//控制图片轮播
	// 初始化
	oImgUl.css('width',aImg.length*aImg.outerWidth(true));
	oNavUl.css('width',aNavLi.outerWidth(true)*aNavLi.length);

	oLeBtn.click(function(){
		// 左侧切换按钮
		if(iNum > 0){
			iNum--;
		}
		oImgUl.animate({'left':-iNum*aImg.outerWidth(true)});
		if( iNum < 5){
			oNavUl.animate({'left':0});
		}
	//oNavUl.animate({'left':-iNum*aNavLi.outerWidth(true)});
	});
	oRiBtn.click(function(){
		// 左侧切换按钮
		if(iNum < aNavLi.length - 1){
			iNum++;
		}
		oImgUl.animate({'left':-iNum*aImg.outerWidth(true)});
		if( iNum > 4){

			oNavUl.animate({'left':-(iNum - 4)*aNavLi.outerWidth(true)});
		}
		
	});
	aNavLi.click(function(){
		iNum = $(this).index();
		oImgUl.animate({'left':-iNum*aImg.outerWidth(true)})
	});
}


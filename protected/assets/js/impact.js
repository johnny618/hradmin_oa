(function($){
    $(document).ready(function(){
        navigator.userAgent.match(/msie [67]/i)&&document.write('<h1>请使用ie8及以上版本浏览器查看本页面');

        //下面这段是为了去掉模版默认添加的样式，不去掉会覆盖自己写的
        //鉴于需要兼容它而添加css太麻烦了，索性去掉。未来扩展可以修改这个正则，或者不去掉，然后为他做兼容。。
        $('link').each(function(){
            this.href.match(new RegExp('('+[
                /*样式表白名单开始*/
                'css/impact.css'
                /*样式表白名单结束*/
                ].join('|').replace(/\./g,'\\.')+')','i'))||(this.parentNode.removeChild(this))
        });

        function _t(_o,_c,t){
            t=t||function(){return'';};
            $(_o).mouseover(function(){$(this).addClass(_c+t.call(this));});
            $(_o).mouseout(function(){if(!this.checked)$(this).removeClass(_c+t.call(this));});
        }
        _t('.process-item>.item','item-active');
        _t('a.more','more-active');
        _t('.item-list>li','li-active');
        _t('.selection-page','',function(){
            return (this.className.match(/page\d|$/ig)[0])+'-active';
        });
        (function(){
        $('.q-item').css('height',jQuery('.q-item>ul')[0].children.length*26+13);
        for(var s=$('.selection'),s1=$('.q-item>.item-list'),i=0;i<s.length;i++){
            s[i].q=[s1,i];
            $(s[i]).mousedown(function(){
                s.removeClass('selection-active');
                $(this).addClass('selection-active');
                var _i=this.q[1];
                $('.rule>.more').attr('href',$(this.q[0][_i]).attr('href'));
                this.q[0].each(function(){
                    $(this).animate({top:_i*-($('.q-item>.item-list').height()+50)});
                });
            });
        }
        $(s[0]).mousedown();
        })();
        (function(){
        for(var s=$('.selection-page'),s1=$('.tongzhi-container>.tongzhi-item'),i=0;i<s.length;i++){
            s[i].q=[s1,i];
            $(s[i]).mousedown(function(){
                var _i=this.q[1],t=this;
                s.each(function(){
                    $(this)[(this.checked=this==t)?'mouseover':'mouseout']();
                });
                this.q[0].each(function(){
                    $(this).animate({top:_i*-($('.tongzhi-item').height()+10)});
                });
            });
        }
        $(s[0]).mousedown();
        })();







        $(window).resize(function(){
            var w=$('.right-module').width();
            $('.left-module').css('width',$('.left-module').parent().width()-w-3);
            $('.tianqi').css('width',w-18);
        });
        $(window).resize();
    });
})(window.jQuery||window.$);
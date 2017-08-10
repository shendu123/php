// Download by http://www.jb51.net
var suningImages = function(){
	var bigli = $('#bigpics li');
	var image = $('#pics');
	var btn = image.find('li');
	var prev_img = $('.prev_img');
	var next_img = $('.next_img');
	var len = btn.length ;
	var ul = image.find('ul');
	return{
		init:function(){
			var that = this ;
			var posx ;
			var posy ;
			var i = 0 ;
			ul.css('width',len*92);
			image.prev('div').click(function(e){
				//alert($(this));
				if(i<=0){
					return false;
				}
				i--;
				that.scroll(i);
				e.preventDefault();
			})
			
			image.next('div').click(function(e){
				if(i>= parseInt(len/5) || len<=5 ){
					return false;
				}
				i++;	
				that.scroll(i);
				e.preventDefault();
			})
			btn.each(function(i){
				$(this).find('a').click(function(e){
					index = i ;							 
					that.addbk(i);
					that.loadimg(i);
					e.preventDefault();
				})
			})
			var index = 0 ;
			
			$(document).keyup(function(e){
				var e = e || window.event ;
				if(e.which == 39){
					index++;
					if(index>=len){
						index=0;
						ul.stop().animate({marginLeft: 0 },300);
					}
					that.next(index);
					
				}else if(e.which== 37 ){
					index--;
					if(index<0){
						index=len-1;
						ul.stop().animate({marginLeft: -92*parseInt(index/5)*5 },300);
					};
					that.prev(index);
				}
			});
			
		},
		loadimg:function(i){
			bigli.hide();
			bigli.eq(i).show();

		},
		addbk:function(i){
			btn.eq(i).find('a').addClass('on').parent().siblings().find('a').removeClass('on');
		},
		scroll:function(i){
			ul.stop().animate({marginLeft: -92*5*i },300);
		},
		next:function(index){
			var that = this ;
			if(((index)%5)==0){
				ul.stop().animate({marginLeft: -92*(index) },300);
			}
			that.addbk(index);
			setTimeout(function(){that.loadimg(index);},400);
		},
		prev:function(index){
			var that = this ;
			if((index+1)%5==0){
				ul.stop().animate({marginLeft: -92*parseInt(index/5)*5 },300);
			}
			that.addbk(index);
			setTimeout(function(){that.loadimg(index);},400);
		}
	}
}
$(document).ready(function(){
	suningImages().init();	
})

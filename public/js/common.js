$(document).ready(function(){
    //创建vue实例
	var vm =new Vue({
		el:'#header',
		data:{
			navigation_data:{},//左侧导航信息
		},
		methods:{
			// select_right:function(index){
			// 	$('.fl_slider_right').show();
			// 	$('.fl_slider_right').find('.list_info').eq(index).show().siblings().hide();
			},
			select_leave:function(){
				// $('.fl_slider_right').hide();
			},
			select_service:function(project_id){
				window.location.href='/home/project_content/project_content/id/'+project_id;
			}
		}
	});
	//获取左侧导航信息
	$.ajax({
		url:'/home/index/index2',
		type:'post',
		success:function(res){
			vm.navigation_data=res.data;
		}
	});

	 $('.location').on('click',function(){
	  $('.location_content').slideToggle();
	 })
     $('.location_content li').on('click',function(){
      $('.location_text').text($(this).text());
      $('.location_content').slideToggle();
     })

     $('#header .listnavbar .fl').on({
     	mouseenter:function(){
     		$('.fl_slider').fadeToggle();
     	},
     	mouseleave:function(){
     		$('.fl_slider').fadeToggle();
     	}
     })
})

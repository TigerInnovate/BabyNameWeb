$('#submitPaidSuc').on({
	click:function(){
		var phonenumber = $('#submitPaidPhonenumber').val();
		if(phonenumber ==''){
			babyTool.showTips('请填写手机号码，方便我们联系您。');
			return false;
		}else if(!babyTool.isPhone(phonenumber)){
			babyTool.showTips('请填写正确的手机号码，方便我们联系您。');
			return false;
		}
		var order_num = $('#paid_order_num').val();
		$.post('bindMobile.php',{mobile:phonenumber,order_num:order_num},function(re){
			if(re=='success'){
				window.location.href = 'quming/quminglist.php?order_num='+order_num;
			}else{
				alert('绑定失败');
			}
		})
	}
})
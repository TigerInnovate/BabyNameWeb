jQuery(document).ready(function($) {
	function orderListSearch(searchText){
		$.ajax({
			url: '/myOrder',
			type: 'POST',
			dataType: 'JSON',
			data: {param1: searchText},
		})
		.done(function(result) {
			console.log(result);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}

	$('#textSearch').on({
		blur:function(){
			var  searchText = $(this).val();
			if (event.keyCode == "13") {
			    orderListSearch( searchText);
			}
		}
	})
});
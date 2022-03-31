$(':input').on('change',function(){

	$('#main-error').click();
	$(this).parent().removeClass('error');

});
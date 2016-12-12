
$(document).ready(function(){
    

	$("#form_factura").on("click",function(event)
	{
		if($(this).prop("checked"))
			$(".facturacion").slideDown();
		else
			$(".facturacion").slideUp();
		
	});
});

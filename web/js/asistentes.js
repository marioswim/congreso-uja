
$(document).ready(function(){
    console.log("erer");

	$("#more-btn").on("click",function(event)
	{
		event.preventDefault();
		$(this).parent().children(".more").slideToggle();
	});
});

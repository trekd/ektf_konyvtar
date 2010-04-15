$().ready(function() {
	$("form > label").click(function () {
		$(this).next("input").focus();
	});

	$("label.inlined + input").each(function (type) {
 
      		if($(this).val() != "") {
      			$(this).prev("label.inlined").addClass("has-text").removeClass("focus");
		}
 
	     	$(this).focus(function () {
	      		$(this).prev("label.inlined").addClass("focus");
	     	});

	     	$(this).keypress(function () {
	      		$(this).prev("label.inlined").addClass("has-text").removeClass("focus");
	     	});

	     	$(this).blur(function () {
	      		if($(this).val() == "") {
	      			$(this).prev("label.inlined").removeClass("has-text").removeClass("focus");
      			}
		});
	});
});

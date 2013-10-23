(function() {
$(document).ready(function() {	
	var selection = $("#search_by_cat select");
	var join_cat = $("#search_by_cat input[type='submit']");
	var selected_group;
	
	join_cat.on("click", function() {
		if (selected_group)
		{
			$.ajax ({
			type: "POST",
			url: "php/join_group.php",
			data: {
				selectedGroup : selected_group
			},
			success: function(msg) {	
				showPopUp("You are in " + selected_group + " now");
				selection.change();
				$("#email_find").click();
			},
			error: function(msg) {
				console.log(msg);
			}
		})
		}
	});
	
	
	function showPopUp(msg) 
	{
		$("#popup").text(msg);
		$( "#popup" ).dialog({
			show: {effect: 'fade', duration: 200},
			hide: {effect: 'fade', duration: 100},
		  modal: true
		});
	}
	
	selection.on("change", function() {
		var selected = selection.find(":selected").text();
		$.ajax ({
			type: "POST",
			url: "php/get_groups_by_categories.php",
			data: {
				category : selected,
			},
			success: function(grp) {		
				$("#search_by_cat .result").html(grp);
			},
			error: function(msg) {
				console.log(msg);
			}
		}).done(function() {
			var anchors = $("#search_by_cat a");
			
			anchors.on("click", function(e) {
				anchors.removeClass("selected");
				var selected = $(this).addClass("selected");
			
				$.ajax ({
					type: "POST",
					url: "php/get_group_description2.php",
					data: {
						group: selected.text()
					},
					success: function(desc) {					
						$("#search_by_cat .desc").html(desc);
						console.log(desc);
					},
					error: function(msg) {
						console.log(msg);
					}
				})				
				selected_group = $(this).text();
				
				e.preventDefault();
			});
		});
		
	});
	// end selection on change
	
	// default value when first open the page
	selection.change();
	
	////////////////// GROUP SEARCH BY EMAIL //////////////////
	var email_result = $("#search_by_email .result").hide();
	var email_join = $("#email_join").hide();
	
	
	email_join.on("click", function() {
		if (selected_group)
		{
			$.ajax ({
			type: "POST",
			url: "php/join_group.php",
			data: {
				selectedGroup : selected_group
			},
			success: function(msg) {	
				showPopUp("You are in " + selected_group + " now");
				selection.change();
				$("#email_find").click();
			},
			error: function(msg) {
				console.log(msg);
			}
		})
		}
	});
	
	
	
	$("#email_find").on("click", function() {
		var email = $("#email").val();	
		if (email != "")
		{
			$.ajax ({
				type: "POST",
				url: "php/get_groups_by_emails.php",
				data: {
					email: email
				},
				success: function(grp) {	
					if (grp != '') 
					{
						email_result.html(grp).slideDown();
						email_join.slideDown();
						$("html, body").animate({ scrollTop: $(document).height() }, 500);
					}
					else
					{
						email_result.html(grp).slideUp();
						email_join.slideUp();
					}
				},
				error: function(msg) {
					email_result.html(grp).slideUp();
					email_join.slideUp();
				}
			}).done(function() 
			{
				var anchors = $("#search_by_email a");
				anchors.on("click", function(e) {
					anchors.removeClass("selected");
					var selected = $(this).addClass("selected");
					selected_group = $(this).text();
					
					e.preventDefault();
				});
			});
		}
	});
		
	
});	
// end document ready
})();

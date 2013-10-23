(function() {
$(document).ready(function() {		
	var content = $("#content").hide();
	var groups = $("#groups").hide();
    var general_stats = $("#general_stats");   
    var general_stat1 = $("#general_stat1");
    var general_stat2 = $("#general_stat2");
    var general_stat3 = $("#general_stat3");
    var general_stat4 = $("#general_stat4");
    var write_post = $("#write_post");
    var post_message = $(".post_message");
    var grp_descr = $("#grp_descr").hide();
    var description = $("#description");
	var g_stat_wrapper = $("#gstat-wrapper").hide();
    var cur_group;
	
	

	$(".post_message").on("click", function(e) {
		var message_box = $("#write_post");
		$.ajax ({
			type: "POST",
			url: "php/write_post.php",
			data: {
				message : message_box.val(),
				group : cur_group.text()
			},
			success: function(post) {		
				var posts = $("#group_posts ul");				
				console.log(post);
				posts.prepend(post);
				posts.children(":first").hide().slideDown();
				addDeleteHandler();
				addEditHandler();
				
				message_box.val("");
			},
			error: function(msg) {
				console.log(msg);
			}
		});
	});
	
	
	$.ajax({
		type: "POST",
		url: "php/get_joined_groups.php",
		success: function(group_names) {			
			groups.append(group_names);		
			groups.fadeIn();
		},
		error: function(msg) {
			console.log(msg);
		}

	}).done(function() {
           
	$('#stat-wrapper h1').fadeIn('slow');
		
	 $.ajax({
        type: "POST",
        url: "php/grp_most_usr.php",
        success: function(grp_most_usr) {
            general_stat3.html("Most popular group: " + grp_most_usr).hide();
        },
        error: function(msg) {
            console.log(msg);
        }
    }).done(function() {
    $.ajax({
        type: "POST",
        url: "php/tot_num_usr.php",
        success: function(tot_num_usr) {			
            general_stat1.html("Total number of users: " + tot_num_usr).hide();
        },
        error: function(msg) {
            console.log(msg);
        }
    });
	}).done(function() {
    $.ajax({
        type: "POST",
        url: "php/tot_num_grp.php",
        success: function(tot_num_grp) {	
            general_stat2.html("Total number of interest groups: " + tot_num_grp).hide();
        },
        error: function(msg) {
            console.log(msg);
        }
    }).done(function() {
		general_stat1.slideDown();
		general_stat2.slideDown();
		general_stat3.slideDown();
        general_stat4.slideDown();
	});
	});
			
	$("#groups a").on("click", function(e) {	
		 if(typeof cur_group !== "undefined"){
		   cur_group.removeClass("selected");
		 };	
		cur_group = $(this).addClass("selected");
        general_stats.hide();
        general_stat1.hide();
        general_stat2.hide();
        general_stat3.hide();	     
		g_stat_wrapper.fadeOut();
        content.fadeOut();

        $.ajax({
            type: "POST",
            url: "php/get_group_description.php",
            data: {
                "selected_group": $(cur_group).text()
            },
            success: function(descr) {
				$("#stat-wrapper").hide();				
                description.html(descr);                
            },
            error: function(msg) {
                console.log(msg);
            }
        }).done(function() {
		
        $.ajax({
            type: "POST",
            url: "php/all_grp_usr.php",
            data: {
                "selected_group": $(cur_group).text()
            },
            success: function(all_grp_usr) {
                $("#statistics1").html("Total number of users in this group: " + all_grp_usr);
            },
            error: function(msg) {
                console.log(msg);
            }
        });
		}).done(function() {
        $.ajax({
            type: "POST",
            url: "php/num_of_single_f.php",
            data: {
                "selected_group": $(cur_group).text()
            },
            success: function(num_of_single_f) {
                $("#statistics2").html("Number of SINGLE FEMALES in this group: " + num_of_single_f);
            },
            error: function(msg) {
                console.log(msg);
            }
        });
		}).done(function() {
        $.ajax({
            type: "POST",
            url: "php/num_of_single_m.php",
            data: {
                "selected_group": $(cur_group).text()
            },
            success: function(num_of_single_m) {
                $("#statistics3").html("Number of SINGLE MALES in this group: " + num_of_single_m);
            },
            error: function(msg) {
                console.log(msg);
            }
        });
		}).done(function() {
		
		$.ajax({
			type: "POST",
			url: "php/get_group_details.php",					
			data: {
				"selected_group": cur_group.text()
			},
			beforeSend: function() {
              cur_group.prev().show();
            },
			success: function(group_details) {				
				$("#group_name").html(group_details);	
				$("html, body").animate({ scrollTop: 0 }, "slow");		
			},
			error: function(msg) {
				console.log(msg);
			}	
		}).done(function() {
		
		$.ajax({
			type: "POST",
			url: "php/get_group_posts.php",					
			data: {
				"selected_group": $(cur_group).text()
			},
			success: function(group_posts) {
				$("#group_posts").html(group_posts);				
			},
			error: function(msg) {
				console.log(msg);
			}
		}).done(function() {
			$(".loading_image").hide();
			content.fadeIn();
			 grp_descr.fadeIn();
			description.fadeIn('slow');			
			g_stat_wrapper.fadeIn('slow');

			addDeleteHandler();
			addEditHandler();


		});
		});
		});
		e.preventDefault();
	});
	});
});

function addDeleteHandler()
{
	$(".delete").on("click", function(e) {
		var postLI = $(this).parent("li");
		var pid = postLI.data("pid");
		
		$.ajax({
			type: "POST",
			url: "php/delete_post.php",					
			data: {
				post_id: pid
			},
			success: function(msg) {
				postLI.slideUp();						
			},
			error: function(msg) {
				console.log(msg);
			}
		});
		e.preventDefault();
	});
}

function addEditHandler() 
{
	$(".edit").on("click", function(e) {
		var postLI = $(this).parent("li");
		var message = postLI.children(".message");
		var pid = postLI.data("pid");
		var editDIV = postLI.children(".edit_post");
		var editForm = editDIV.children("textarea");
		var confirm = editDIV.children(".confirm");				
		// hide current post
		editDIV.fadeIn();
		message.hide();
		
		confirm.on("click", function(e) {
			$.ajax({
				type: "POST",
				url: "php/edit_post.php",					
				data: {
					post_id: pid,
					message : editForm.val()
				},
				success: function(msg) {					
					editDIV.hide();
					var new_msg = editForm.val().replace(/\n/g, '<br />');
					message.html(new_msg).fadeIn();		
				},
				error: function(msg) {
					console.log(msg);
				}
			});
			e.preventDefault();
		});
		
		e.preventDefault();
	});
}

})();

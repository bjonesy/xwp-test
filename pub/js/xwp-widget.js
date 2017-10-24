( function( $ ) {
	// Create ids
	var id = 0;
	var post_id = 0;
	var user_id = 0;
	var comment_id = 0;

	// Add ids to each widget element
	$( '.xwp-widget' ).each( function() {
		$( this ).attr( 'id', 'xwp-widget-' + id++ );
	} );
	$( '.xwp-widget__posts' ).each( function() {
		var p_posts = $( '<p />' );
		$( this ).append( p_posts );
		$( this ).attr( 'id', 'xwp-widget__posts-' + post_id++ );
	} );	
	$( '.xwp-widget__users' ).each( function() {
		var p_users = $( '<p />' );
		$( this ).append( p_users );
		$( this ).attr( 'id', 'xwp-widget__users-' + user_id++ );
	} );	
	$( '.xwp-widget__comments' ).each( function() {
		var p_comments = $( '<p />' );
		$( this ).append( p_comments );
		$( this ).attr( 'id', 'xwp-widget__comments-' + comment_id++ );
	} );

	// Check if multisite is enabled
	if ( $( '.xwp-widget-subsite' ).length ) {
		var subsite_id = 0;
		var subsite_posts = 0;
		var subsite_users = 0;
		var subsite_comments = 0;

		// Add ids to each widget element
		$( '.xwp-widget-subsite' ).each( function() {
			$( this ).attr( 'id', 'xwp-widget-subsite-' + subsite_id++ );
		} );
		$( '.xwp-widget-subsite__posts' ).each( function() {
			var p_posts = $( '<p />' );
			$( this ).append( p_posts );
			$( this ).attr( 'id', 'xwp-widget-subsite__posts-' + subsite_posts++ );
		} );
		$( '.xwp-widget-subsite__users' ).each( function() {
			var p_users = $( '<p />' );
			$( this ).append( p_users );
			$( this ).attr( 'id', 'xwp-widget-subsite__users-' + subsite_users++ );
		} );
		$( '.xwp-widget-subsite__comments' ).each( function() {
			var p_users = $( '<p />' );
			$( this ).append( p_users );
			$( this ).attr( 'id', 'xwp-widget-subsite__comments-' + subsite_comments++ );
		} );
	}

	// Get the total number of posts
	var ajax_get_posts = function() {
		$.ajax( {
			method: 'GET',
			// Here we supply the endpoint url, as opposed to the action in the data object with the admin-ajax method
			url: rest_object.api_url + 'total-posts/', 
			beforeSend: function ( xhr ) {
				// Here we set a header 'X-WP-Nonce' with the nonce as opposed to the nonce in the data object with admin-ajax
				xhr.setRequestHeader( 'X-WP-Nonce', rest_object.api_nonce );
			},
			success : function( response ) {
				var total_posts = response;
				$( '.xwp-widget__posts' ).each( function() {
					$( this ).find( 'p' ).empty();
					$( this ).find( 'p' ).append( total_posts );
				} );	
			},
			fail : function( response ) {
				console.log( response );
			}
		} );
	};

	// If this multisite get the subsite posts totals
	var ajax_get_all_subsites_posts = function() {
		var data = {
			'action': 'subdomains_action',
		};
		$.ajax( {
			method: 'POST',
			// Here we supply the endpoint url, as opposed to the action in the data object with the admin-ajax method
			url: rest_object.ajax_url,
			data: data,
			dataType: 'json', 
			beforeSend: function ( xhr ) {
				// Here we set a header 'X-WP-Nonce' with the nonce as opposed to the nonce in the data object with admin-ajax
				xhr.setRequestHeader( 'X-WP-Nonce', rest_object.api_nonce );
			},
			success : function( response ) {
				$( '.xwp-widget-subsite__posts' ).each( function( index, value ) {
					$.each( response, function( idx, val ) {
						if ( idx === index ) {
							$( '#xwp-widget-subsite__posts-' + index ).find( 'p' ).empty();
							$( '#xwp-widget-subsite__posts-' + index ).find( 'p' ).append( val.total_posts );
						}
					} );	
				} );
			},
			fail : function( response ) {
				console.log( response );
			}
		} );
	};

	// Get the total number of users
	var ajax_get_users = function() {
		$.ajax( {
			method: 'GET',
			// Here we supply the endpoint url, as opposed to the action in the data object with the admin-ajax method
			url: rest_object.api_url + 'total-users/', 
			beforeSend: function ( xhr ) {
				// Here we set a header 'X-WP-Nonce' with the nonce as opposed to the nonce in the data object with admin-ajax
				xhr.setRequestHeader( 'X-WP-Nonce', rest_object.api_nonce );
			},
			success : function( response ) {
				var total_users = response['total_users'];
				$( '.xwp-widget__users' ).each( function() {
					$( this ).find( 'p' ).empty();
					$( this ).find( 'p' ).append( total_users );
				} );
			},
			fail : function( response ) {
				console.log( response );
			}
		} );
	};

	// If this multisite get the subsites users totals
	var ajax_get_all_subsites_users = function() {
		var data = {
			'action': 'subdomains_action',
		};
		$.ajax( {
			method: 'POST',
			// Here we supply the endpoint url, as opposed to the action in the data object with the admin-ajax method
			url: rest_object.ajax_url,
			data: data,
			dataType: 'json', 
			beforeSend: function ( xhr ) {
				// Here we set a header 'X-WP-Nonce' with the nonce as opposed to the nonce in the data object with admin-ajax
				xhr.setRequestHeader( 'X-WP-Nonce', rest_object.api_nonce );
			},
			success : function( response ) {
				$( '.xwp-widget-subsite__users' ).each( function( index, value ) {
					$.each( response, function( idx, val ) {
						if ( idx === index ) {
							$( '#xwp-widget-subsite__users-' + index ).find( 'p' ).empty();
							$( '#xwp-widget-subsite__users-' + index ).find( 'p' ).append( val.total_users);
						}
					} );	
				} );
			},
			fail : function( response ) {
				console.log( response );
			}
		} );
	};

	// Get the total number of comments
	var ajax_get_comments = function() {
		$.ajax( {
			method: 'GET',
			// Here we supply the endpoint url, as opposed to the action in the data object with the admin-ajax method
			url: rest_object.api_url + 'total-comments/', 
			beforeSend: function ( xhr ) {
				// Here we set a header 'X-WP-Nonce' with the nonce as opposed to the nonce in the data object with admin-ajax
				xhr.setRequestHeader( 'X-WP-Nonce', rest_object.api_nonce );
			},
			success : function( response ) {
				var total_comments = response['total_comments'];
				$( '.xwp-widget__comments' ).each( function() {
					$( this ).find( 'p' ).empty();
					$( this ).find( 'p' ).append( total_comments );
				} );
			},
			fail : function( response ) {
				console.log( response );
			}
		} );
	};

	// If this multisite get the subsites comments totals
	var ajax_get_all_subsites_comments = function() {
		var data = {
			'action': 'subdomains_action',
		};
		$.ajax( {
			method: 'POST',
			// Here we supply the endpoint url, as opposed to the action in the data object with the admin-ajax method
			url: rest_object.ajax_url,
			data: data,
			dataType: 'json', 
			beforeSend: function ( xhr ) {
				// Here we set a header 'X-WP-Nonce' with the nonce as opposed to the nonce in the data object with admin-ajax
				xhr.setRequestHeader( 'X-WP-Nonce', rest_object.api_nonce );
			},
			success : function( response ) {
				$( '.xwp-widget-subsite__comments' ).each( function( index, value ) {
					$.each( response, function( idx, val ) {
						if ( idx === index ) {
							$( '#xwp-widget-subsite__comments-' + index ).find( 'p' ).empty();
							$( '#xwp-widget-subsite__comments-' + index ).find( 'p' ).append( val.total_comments );
						}
					} );	
				} );
			},
			fail : function( response ) {
				console.log( response );
			}
		} );
	};

	// Run each function to get inital values
	ajax_get_posts();
	ajax_get_users();
	ajax_get_comments();

	// If multisite is enabled
	if ( $( '.xwp-widget-subsite' ).length ) {
		ajax_get_all_subsites_posts();
		ajax_get_all_subsites_users();
		ajax_get_all_subsites_comments();
	}	

	// Interval of 1 minute
	var interval = 1000 * 60 * 1; // Run every minute

	// Set intervals for each function
	setInterval( ajax_get_posts, interval );
	setInterval( ajax_get_users, interval );
	setInterval( ajax_get_comments, interval );

	// If multisite is enabled
	if ( $( '.xwp-widget-subsite' ).length ) {
		setInterval( ajax_get_all_subsites_posts, interval );
		setInterval( ajax_get_all_subsites_users, interval );
		setInterval( ajax_get_all_subsites_comments, interval );
	}	
} )( jQuery );	
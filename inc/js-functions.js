$( "#btn-search" ).click(function() {
    varlocation = $( "#city" ).val();  //  Get city
	varday = $( "#day" ).val();  //  Get day
	
	$.ajax({url: "page-list.php?city=" + varlocation + "&day=" + varday, success: function(result) {
		$( "#container-list" ).html(result);  //  Load list into container div
		$( "#container-list" ).trigger( "create" );  //  Refresh
		
		$( "#listitems li" ).each(function(){  //  Apply this to all the list items
			$( this ).click(function() {
				varlistitem = this.id;  //  Get the id
				$.ajax({url: "page-details.php?selectedlistitem=" + varlistitem + "&city=" + varlocation, success: function(result) {
					$( "#container-details" ).html(result);  //  Load details into container div
					$( "#container-details" ).trigger( "create" );  //  Refresh
				}});
				$( "body" ).pagecontainer( "change", "#page-details", {  //  Slide DETAILS PAGE in
					transition:'slide'
				});
			});
			
		});
	
	}});
    $( "body" ).pagecontainer( "change", "#page-list", {  //  Slide LIST PAGE in
		transition:'slide'
	});
	
});
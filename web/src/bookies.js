"use strict";
$(document).ready(function(){		
	$("button").click(function(){				
		var id  = $(this).attr("id");
		$('#div_' + id).css("display","block");
	});
	
	$("#search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		if ($("#nbaTable").length) {
			$("#nbaTable tr").filter(function() {
			  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		}
		if ($("#nflTable").length) {
			$("#nflTable tr").filter(function() {
			  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		}
		if ($("#mlbTable").length) {
			$("#mlbTable tr").filter(function() {
			  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		}
	});
	
	function filterCheck() {
		var value = $("#sel").val();
		console.log("Triggered");
		switch (value) {
			case "all":
				if ($("#nbaPanel").length) {$("#nbaPanel").show();}
				if ($("#nflPanel").length) {$("#nflPanel").show();}
				if ($("#mlbPanel").length) {$("#mlbPanel").show();}
				break;
			case "nba":
				if ($("#nbaPanel").length) {$("#nbaPanel").show();}
				if ($("#nflPanel").length) {$("#nflPanel").hide();}
				if ($("#mlbPanel").length) {$("#mlbPanel").hide();}
				break;
			case "nfl":
				if ($("#nbaPanel").length) {$("#nbaPanel").hide();}
				if ($("#nflPanel").length) {$("#nflPanel").show();}
				if ($("#mlbPanel").length) {$("#mlbPanel").hide();}
				break;
			case "mlb":
				if ($("#nbaPanel").length) {$("#nbaPanel").hide();}
				if ($("#nflPanel").length) {$("#nflPanel").hide();}
				if ($("#mlbPanel").length) {$("#mlbPanel").show();}
				break;
		}
	}
		
	$("#sel").change(filterCheck);
	filterCheck();
});

function placeBet(id) {
	var gameId = id.slice(3, id.length);
	$("#fm_" + gameId).submit(function(e){
		e.preventDefault();			
		console.log(gameId);
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText.trim();
				switch (response) {
					case "0":
						var alert = '<div class="alert alert-danger alert-dismissable">' +
						'<a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>' +
						'<strong>Cannot complete request.</strong> There is already a bet placed on the opposing team.</div>';
						break;
					case "1":
						var alert = '<div class="alert alert-success alert-dismissable">' +
						'<a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>' +
						'<strong>Success!</strong> Bet placed.</div>';
						break;
					case "2":
						var alert = '<div class="alert alert-warning alert-dismissable">' +
						'<a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>' +
						'Not enough credits to place current bet.</div>';
						break;
					case "3": 
						var alert = '<div class="alert alert-warning alert-dismissable">' +
						'<a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>' +
						'<strong>Not Logged in!</strong> Please log in to place bets.</div>';
						break;
				}
				$("#responseBody").html(alert);
				$('#response').modal('show');
			}
		};
		xhttp.open("POST", "scripts/placebet.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send($("#fm_" + gameId).serialize());
		document.getElementById("fm_" + gameId).reset();
		$('.modal.in').modal('hide');
	});
}
	var $border_color = "#efefef";
	var $grid_color = "#ddd";
	var $default_black = "#666";
	var $green = "#8ecf67";
	var $yellow = "#fac567";
	var $orange = "#F08C56";
	var $blue = "#1e91cf";
	var $red = "#f74e4d";
	var $teal = "#28D8CA";
	var $grey = "#999999";
	var $dark_blue = "#0D4F8B";
	
$(function () {

	var data, chartOptions;
	
	data = [
		{ label: "৳ 3,500,000,000<br> Received", data: Math.floor (Math.random() * 100 + 390) },			
		{ label: "৳ 4,264,051.02<br> Outstanding", data: Math.floor (Math.random() * 100 + 150) }, 
		/*{ label: "Pinaples", data: Math.floor (Math.random() * 100 + 530) }, 
		{ label: "Grapes", data: Math.floor (Math.random() * 100 + 90) },
		{ label: "Bananas", data: Math.floor (Math.random() * 100 + 320) }*/
	];

	chartOptions = {        
		series: {
			pie: {
				show: true,  
				innerRadius: .5, 
				stroke: {
					width: 1,
				}
			}
		}, 
		shadowSize: 0,
		legend: {
			position: 'se'
		},
		
		tooltip: true,

		tooltipOpts: {
			content: '%s: %y'
		},
		
		grid:{
      hoverable: true,
      clickable: false,
      borderWidth: 1,
	  tickColor: $border_color,
      borderColor: $grid_color,
    },
    shadowSize: 0,
		colors: [$green, $grey, $yellow, $teal, $yellow, $green],
	};


	var holder = $('#donut-chart');

	if (holder.length) {
		$.plot(holder, data, chartOptions );
	}		
		
});

//////////////////////////////2nd js/////////////////////////////////////

	var $border_color = "#efefef";
	var $grid_color = "#ddd";
	var $default_black = "#666";
	var $green = "#8ecf67";
	var $yellow = "#fac567";
	var $orange = "#F08C56";
	var $blue = "#1e91cf";
	var $red = "#f74e4d";
	var $teal = "#28D8CA";
	var $grey = "#999999";
	var $dark_blue = "#0D4F8B";
	
$(function () {

	var data, chartOptions;
	
	data = [
		{ label: "<b>05</b> Created", data: Math.floor (Math.random() * 100 + 150) }, 
		{ label: "<b>12</b> Submitted", data: Math.floor (Math.random() * 100 + 390) }, 
		{ label: "<b>0</b> Internal Reject", data: Math.floor (Math.random() * 100 + 530) }, 
		{ label: "<b>05</b> Approved", data: Math.floor (Math.random() * 100 + 90) },
		{ label: "<b>16</b> Rejected", data: Math.floor (Math.random() * 100 + 320) },
		{ label: "<b>20</b> Partially Paid", data: Math.floor (Math.random() * 100 + 90) },
		{ label: "<b>40</b> Paid", data: Math.floor (Math.random() * 100 + 320) },
	];

	chartOptions = {        
		series: {
			pie: {
				show: true,  
				innerRadius: .5, 
				stroke: {
					width: 1,
				}
			}
		}, 
		shadowSize: 0,
		legend: {
			position: 'se'
		},
		
		tooltip: true,

		tooltipOpts: {
			content: '%s: %y'
		},
		
		grid:{
      hoverable: true,
      clickable: false,
      borderWidth: 1,
	  tickColor: $border_color,
      borderColor: $grid_color,
    },
    shadowSize: 0,
		colors: [$yellow, $yellow, $red, $green, $red, $green],
	};


	var holder = $('#donut-chart1');

	if (holder.length) {
		$.plot(holder, data, chartOptions );
	}		
		
});
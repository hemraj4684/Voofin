//////////////////////// Select Box All Select Js Start ///////////////////////////
$(function () {
	$('.lstFruits').multiselect({
		includeSelectAllOption: true
	});
	$('#btnSelected').click(function () {
		var selected = $(".lstFruits option:selected");
		var message = "";
		selected.each(function () {
			message += $(this).text() + " " + $(this).val() + "\n";
		});
		alert(message);
	});
});
//////////////////////// Select Box All Select Js End ///////////////////////////

//////////////////////// Upload File Js Start ///////////////////////////
$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
	  numFiles = input.get(0).files ? input.get(0).files.length : 1,
	  label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
	$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
		
		var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;
		
		if( input.length ) {
			input.val(log);
		} else {
			if( log ) alert(log);
		}
		
	});
});
//////////////////////// Upload File Js End ///////////////////////////

//////////////////////// Tooltip Js Start ///////////////////////////
$(function () { $("[title]").tooltip(); });
//////////////////////// Tooltip Js Start ///////////////////////////

//////////////////////// Radio Button Js Start ///////////////////////////
			$(':radio').change(function (event) {
			var id = $(this).data('id');
			$('#' + id).addClass('none').siblings().removeClass('none');
		});
	
//////////////////////// Radio Button Js End ///////////////////////////
	
//////////////////////// Date Picker Js Start ///////////////////////////
	
	$('.date_filter').daterangepicker({
	   "showDropdowns": true,
	   "startDate": moment().subtract(30,'days'),
       "endDate": moment(),
       locale:{
       	format : "DD MMM YYYY",
       },
		"ranges": {
		   'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
		"autoUpdateInput": false,
		
	}, function(start, end, label) {
	  console.log("New date range selected: ' + start.format('DD MMM YYYY') + ' to ' + end.format('DD MMM YYYY') + ' (predefined range: ' + label + ')");
	});


	
	$('.date_filter').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD MMM YYYY') + ' - ' + picker.endDate.format('DD MMM YYYY'));
     });

    $('.date_filter').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });
      
//////////////////////// Date Picker Js End ///////////////////////////
	
//////////////////////// Data Table Js Start ///////////////////////////
	
		// Setup - add a text input to each footer cell
		$('#example thead tr#filterrow th').each( function () {
		var title = $('#example thead th').eq( $(this).index() ).text();
		$(this).html( '<input type="text" onclick="stopPropagation(event);" class="form-control" placeholder="" /><i class="fa fa-search search_icon"></i>');
		} );

		// DataTable
		var table = $('#example').DataTable( {
		
		orderCellsTop: true
			
		} );

		// Apply the filter
		$("#example thead input").on( 'keyup change', function () {
		table
			.column( $(this).parent().index()+':visible' )
			.search( this.value )
			.draw();
		} );

		function stopPropagation(evt) {
		if (evt.stopPropagation !== undefined) {
			evt.stopPropagation();
		} else {
			evt.cancelBubble = true;
		}
		}
	
//////////////////////// Data Table Js End ///////////////////////////
	
//////////////////////// Onclick Show Hide Js Start ///////////////////////////
    
		var select = document.getElementById('test'),
		onChange = function(event) {
		var shown = this.options[this.selectedIndex].value == 1;

		document.getElementById('hidden_div').style.display = shown ? 'block' : 'none';
		};

		if (select.addEventListener) {
		select.addEventListener('change', onChange, false);
		} else {
		select.attachEvent('onchange', function() {
		onChange.apply(select, arguments);
		});
		}
	
//////////////////////// Onclick Show Hide Js End ///////////////////////////
	    
//////////////////////// Page ScrollUp And Tooltip Start ///////////////////////////
      $(function () {
        $.scrollUp({
          scrollName: 'scrollUp', // Element ID
          topDistance: '300', // Distance from top before showing element (px)
          topSpeed: 300, // Speed back to top (ms)
          animation: 'fade', // Fade, slide, none
          animationInSpeed: 400, // Animation in speed (ms)
          animationOutSpeed: 400, // Animation out speed (ms)
          scrollText: 'Top', // Text for element
          activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        });
      });

      //Tooltip
      $('a').tooltip('hide');
      $('i').tooltip('hide');

      // SparkLine Bar
      $(function () {
        $("#emails").sparkline([3,2,4,2,5,4,3,5,2,4,6,9,12,15,12,11,12,11], {
        type: 'line',
        width: '200',
        height: '70',
        lineColor: '#3693cf',
        fillColor: '#e5f3fc',
        lineWidth: 3,
        spotRadius: 6
        });
      });

   
//////////////////////// Page ScrollUp And Tooltip Js End ///////////////////////////
	
//////////////////////// Input Field Edit Js Start ///////////////////////////
		function toggle() {	
			$('#inputText').attr("readonly",false).focus();
			$('#hide_btn').hide();
			$('#show_btn').show();
		} 
		function toggleupdate() {	
			$('#inputText').attr("readonly",true).focus();
			$('#hide_btn').show();
			$('#show_btn').hide();	
		}
///////////////////////////Input Field Edit Js ENd ///////////////////////////	


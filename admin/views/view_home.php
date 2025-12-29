<style>
  .home-icon {
   margin-top: 30px !important;
   font-size: 16px !important;
 }
 .home_table td, .home_table th {
   border-right: 1px solid #f4f4f4;
 }
</style>
<?php include("includes/header.php"); ?>
<script src="../resources/fullcalendar/moment.min.js"></script>
<script src='../resources/fullcalendar/fullcalendar.js'></script>
<link rel='stylesheet' href="../resources/fullcalendar/fullcalendar.min.css" />
<script type="text/javascript" src="../resources/fullcalendar/semantic.min.js"></script>
<!-- <link href='../resources/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' /> -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Booking Calendar</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
	   </section>
        <!-- Main row for calender -->
	    <section class="content">
	  <div class="card mb-0">
              <div class="card-body">
                <div class="ui dBox box-block bg-white" style="background-color: #f3f3f3; width: 100%">
                  <div class="ui grid">
                    <div class="ui sixteen column">
                      <div id="calendar"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      </section>
<?php include("includes/footer.php") ?>
<script type="text/javascript">
	$(document).ready(function() {
    $('#calendar').fullCalendar({
      plugins: [ 'dayGrid', 'timeGrid' ],
      header: {
       left: 'prevYear,prev,next,nextYear today',
       center: 'title',
       right: 'month,basicWeek,basicDay,listMonth'
     },
		nextDayThreshold:'00:00:00',  // it will start the day from 00:00
		defaultDate: '<?php echo date('Y-m-d'); ?>',
		navLinks: true, // can click day/week names to navigate views
		editable: false,
		eventLimit: true, // allow "more" link when too many events
		//events: '../scripts/ajax/get_calendar_bookings.php?from=admin<?php echo ($_SESSION['admin_user_group_id']!='1'?"&branch_id=".$_SESSION['branch_id']:""); ?>',
		timeFormat: 'h(:m)a',
		eventClick:function(event){
			if (event.url) {
				$.fancybox({
					'href'  : event.url,
					'width'       : '50%',
					'height'      : '100%',
					'autoScale'     : false,
					'position' : 'absolute',
					'transitionIn'  : 'elastic',
					'transitionOut' : 'elastic',
					'type'          : 'iframe'
				});
				return false;
			}
		},
    eventRender: function(event, element) {
      $(element).tooltip({
        title: event.title,
        placement: "top",
        container: 'body',
      });
    },
  });
  });
	function change_calendar(){
		var service_provider_id = $('#service_provider_id').val();
		if(service_provider_id>0){
			$('.service_provider_id').addClass('active');
			$('.booking_cal').removeClass('active');
			var myevents = '../scripts/ajax/get_calendar_bookings.php?from=admin&service_provider_id='+service_provider_id;
			$('.fc-event').remove();
			$('#calendar').fullCalendar( 'removeEvents');
			$('#calendar').fullCalendar('removeEventSources');
			$('#calendar').fullCalendar( 'addEventSource', myevents);
		}else{
			$('.booking_cal').addClass('active');
			$('.service_provider_id').removeClass('active');
			var myevents = '../scripts/ajax/get_calendar_bookings.php?from=admin&service_provider_id='+service_provider_id;
			$('.fc-event').remove();
			$('#calendar').fullCalendar( 'removeEvents');
			$('#calendar').fullCalendar('removeEventSources');
			$('#calendar').fullCalendar( 'addEventSource', myevents);
      /*$('#calendar').fullCalendar({
        eventRender: function(event, element) {
          $(element).tooltip({title: event.title});
        }
      });*/
    }
  }
</script>

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/metronic/global/plugins/respond.min.js"></script>
<script src="assets/metronic/global/plugins/excanvas.min.js"></script> 
<![endif]-->

<script src="assets/metronic/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="assets/metronic/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<?php if(strtolower(uri_segment(2))!=="signin")
{?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/metronic/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<script src="assets/metronic/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script><?php }?>
<script src="assets/metronic/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/metronic/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/metronic/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/metronic/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/metronic/global/plugins/select2/select2.min.js"></script>
<?php if(strtolower(uri_segment(2))=="profile")
{?>
<script src="assets/metronic/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/metronic/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="assets/metronic/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<?php }
else if(strtolower(uri_segment(2))=="signin")
{?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/metronic/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/metronic/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/metronic/admin/pages/scripts/login-soft.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<?php }?>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
var uri_2="<?=strtolower(uri_segment(2))?>";
var uri_3="<?=strtolower(uri_segment(3))?>";
jQuery(document).ready(function() {    
	
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   Demo.init(); // init demo features
   
   if(uri_2=='profile')	
   {
	   QuickSidebar.init(); // init quick sidebar	
	   Index.init();   
	   Index.initDashboardDaterange();
	   Index.initJQVMAP(); // init index page's custom scripts
	   Index.initCalendar(); // init index page's custom scripts
	   Index.initCharts(); // init index page's custom scripts
	   Index.initChat();
	   Index.initMiniCharts();
	   Tasks.initDashboardWidget(); 
   }
   else if(uri_2=='signin')
   {	  
  		Login.init();
		// init background slide images
		$.backstretch([
			"<?=base_url()?>assets/metronic/admin/pages/media/bg/1.jpg",
			"<?=base_url()?>assets/metronic/admin/pages/media/bg/2.jpg",
			"<?=base_url()?>assets/metronic/admin/pages/media/bg/3.jpg",
			"<?=base_url()?>assets/metronic/admin/pages/media/bg/4.jpg"
			], {
			  fade: 1000,
			  duration: 8000
		});
   }
   
   
});

</script>
<!-- END JAVASCRIPTS -->
</html>
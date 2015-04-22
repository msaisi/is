<?php
$periods=create_validity();
?>
<script type="text/javascript">
/*
"processing": true,
		"serverSide": true,
		"ajax": $.fn.dataTable.pipeline( {
			url: 'scripts/server_processing.php',
			pages: 5 // number of pages to cache
		} )*/


   $(document).ready(function() {		
   oTable=$('#tbl_my_packages').dataTable( {
	   "bProcessing": true,
		"bServerSide": true,				
		"sAjaxSource": 'ajax_load/get_my_packages?inst_id=<?=$institution['institution_id']?>',
		"bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayStart ":10,
		 "aoColumns": [
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
	        ],
		"oLanguage": {
            "sProcessing": "<img src='assets/images/ajax-loader_dark.gif'>"
        },
		"aaSorting": [[0, 'asc']],
	   	"sDom": 'T<"clear">lfrtip',
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                   // $('td', nRow).attr('nowrap','nowrap');
                    return nRow;
                    },
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 25, 50,100,500,1000], [10, 25, 50,100,500,1000]],
		
		'fnServerData': function(sSource, aoData, fnCallback)
            {
			 aoData.push({name: '<?=$this->security->get_csrf_token_name(); ?>', value: '<?=$this->security->get_csrf_hash(); ?>'});	
              $.ajax
              ({
                'dataType': 'json',
                'type'    : 'post',
                'url'     : sSource,
                'data'    : aoData,
                'success' : fnCallback
              });
            },
		"oTableTools": {
			"sSwfPath": "assets/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
			{
					"sButtonText": "Pdf Export",
					"sExtends": "pdf",
					"sPdfOrientation": "landscape",
					"mColumns": [ 0, 1,2 ]
				}
			,
			{
				"sExtends": "xls",
				"sButtonText": "Excel Export",
				"mColumns": [ 0, 1,2 ]
            }
			,
			{
				"sExtends": "csv",
				"sButtonText": "CSV Export",
				"mColumns": [ 0, 1,2 ]
            }]	},
    } );
	$("#disp_item").keyup( function() { fnFilterColumn('tbl_my_packages',"disp_item", 0 ); } );
	$("#start_date").change( function() { fnFilterColumn('tbl_my_packages',"start_date", 1 ); } );
	$("#start_date").keyup( function() { fnFilterColumn('tbl_my_packages',"start_date", 1 ); } );
	
	$("#end_date").change( function() { fnFilterColumn('tbl_my_packages',"end_date", 2 ); } );
	$("#end_date").keyup( function() { fnFilterColumn('tbl_my_packages',"end_date", 2 ); } );
	
 } );
</script>
<div class="col-md-12">
<div class="col-md-12 white-row">
 

<?php if(!empty($packages))
{ ?>
<div class="col-md-12">

<div class="about_header">
<i class="fa fa-rss-square"></i> Currently Subsribed Package
<hr/>
</div>
<table class="table table-bordered table-striped contacts_div">
  <!-- table head -->
  <thead>
  <tr><!-- item -->
        <th>Package</th>
        <th>Start Date</th>
        <th>Expiry Date</th>
   </tr>
  </thead>
   <!-- table items -->
    <tbody>
    <?php foreach($packages as $row):	?>
        <tr><!-- item -->
            <td><?=$row['name']?></td>
            <td><?=format_full_date($row['start_date'])?></td>
            <td><?=format_full_date($row['expiry_date'])?></td>
        </tr>
    <?php  endforeach;  ?>       
    </tbody>
</table>

<div class="row-fluid">
<div class="about_header">
<i class="fa fa-bolt"></i> Filters
<hr/>
</div>
</div>
<div class="row-fluid">


<div class="col-md-2">
<label>Package</label>
<input name="disp_item" id="disp_item" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<div class="col-md-3">
<label>Start Date</label>
<div id="sandbox-container">
<input name="start_date" id="start_date" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
</div>
<div class="col-md-3">
<label>Expiry Date</label>
<div id="sandbox-container">
<input name="end_date" id="end_date" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
</div>
<div class="gap gap-small"></div>
</div>
<div class="about_header">
<i class="fa fa-clock-o"></i> History
<hr/>
</div>

<div class="row-fluid">
 <table class="table table-responsive table-bordered table-striped" id="tbl_my_packages">
    <thead>
      <tr>
        <th>Package</th>
        <th>Start Date</th>
        <th>Expiry Date</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
</div>
<?php
 } 
else {?>
<div class="alert alert-danger">
    <i class="fa fa-wrench"></i> 
   <span>Sorry, you have not yet subscribed to any of our premium packages.</span>
</div>
<?php }?>
</div>



</div>
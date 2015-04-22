<?php
$conf=$this->fuel->gradstate->config();
$act_status=$conf['yes_no'];
?>
<script type="text/javascript">
   $(document).ready(function() {		
	oTable = $('#tbl_my_courses').DataTable( { 
		"bProcessing": true,
		"bServerSide": true,				
		"sAjaxSource": 'ajax_load/get_my_courses?inst_id=<?=$institution['institution_id']?>',
		"bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayStart ":25,
		 "aoColumns": [
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": false, "bSortable": false },
	        ],
		"oLanguage": {
            "sProcessing": "<img src='assets/images/ajax-loader_dark.gif'>"
        },
		"aaSorting": [[1, 'asc']],
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
					"mColumns": [ 0, 1,2,3,4 ]
				}
			,
			{
				"sExtends": "xls",
				"sButtonText": "Excel Export",
				"mColumns": [ 0, 1,2,3,4 ]
            }
			,
			{
				"sExtends": "csv",
				"sButtonText": "CSV Export",
				"mColumns": [ 0, 1,2,3,4 ]
            }]	},
    } );
	
	$("#ref_no").keyup( function() { fnFilterColumn('tbl_my_courses',"ref_no", 0 ); } );
	$("#course").keyup( function() { fnFilterColumn('tbl_my_courses',"course", 1 ); } );
	$("#disp_date").change( function() { fnFilterColumn('tbl_my_courses',"disp_date", 2 ); } );
	$("#disp_date").keyup( function() { fnFilterColumn('tbl_my_courses',"disp_date", 2 ); } );
	
	$("#disp_status").change( function() { fnFilterColumn('tbl_my_courses',"disp_status", 4 ); } );
	
	$("#pending").change( function() { fnFilterColumn('tbl_my_courses',"pending", 3 ); } );
	
	
});
</script>
<div class="col-md-12">
<div class="col-md-12 white-row">
<div class="row-fluid">
<div class="about_header">
<i class="fa fa-bolt"></i> Filters
<hr/>
</div>
</div>
<div class="row-fluid">


<div class="col-md-2">
<label>Reference No</label>
<input name="ref_no" id="ref_no" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<div class="col-md-3">
<label>Course Title</label>
<input name="course" id="course" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<div class="col-md-2">
<label>Registration Date</label>
<div id="sandbox-container">
<input name="disp_date" id="disp_date" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
</div>
<div class="col-md-2">
<label>Pending Status</label>
<select name="pending" id="pending" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($act_status as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>
<div class="col-md-2">
<label>Active Status</label>
<select name="disp_status" id="disp_status" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($act_status as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>

<div class="gap gap-small"></div>
</div> 


<a href="account/course_add" class="btn btn-primary btn-xs"><i class="fa fa-plus-square"></i>Add Course</a>
<div class="dap gap-mini"></div>


<?php if(!empty($courses))
{ ?>
<div class="col-md-12">
<div class="about_header">
<i class="fa fa-book"></i> My Courses
<hr/>
</div>
<div class="row-fluid">
  <table class="table table-responsive table-bordered table-striped" id="tbl_my_courses">
    <thead>
      <tr>
        <th>Reference No.</th>
        <th>Course Title</th>
        <th>Registration Date</th>
        <th>Pending Approval</th>
        <th>Active</th>
        <th>&nbsp;</th>
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
    <span>Sorry, you have not yet added courses on Gradstate.</span>
</div>
<?php }?>
</div>



</div>
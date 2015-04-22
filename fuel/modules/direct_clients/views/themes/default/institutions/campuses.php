<?php
$conf=$this->fuel->gradstate->config();
$where=array('tbl_institution_campuses.institution_id'=>$institution['institution_id']);
$act_status=$conf['yes_no'];
$disp_locs=remove_null_values($this->gradstate_campuses_model->options_list('campus_location','campus_location',$where));

$disp_campuses=remove_null_values($this->gradstate_campuses_model->options_list('campus_name','campus_name',$where));
?>
<script type="text/javascript">
   $(document).ready(function() {		
	oTable = $('#tbl_my_campuses').DataTable( {
		"bProcessing": true,
		"bServerSide": true,				
		"sAjaxSource": 'ajax_load/get_my_campuses?inst_id=<?=$institution['institution_id']?>',
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
		
"aaSorting": [[0, 'asc']],
		"sDom": 'T<"clear">lfrtip',
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    $('td', nRow).attr('nowrap','nowrap');
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
				"mColumns": [ 0, 1,2,3,4]
            }
			,
			{
				"sExtends": "csv",
				"sButtonText": "CSV Export",
				"mColumns": [ 0, 1,2,3,4 ]
            }]	},
    } );
	
	$("#disp_campus").change( function() { fnFilterColumn('tbl_my_campuses',"disp_campus", 0 ); } );
	$("#disp_loc").change( function() { fnFilterColumn('tbl_my_campuses',"disp_loc", 3 ); } );
	$("#disp_status").change( function() { fnFilterColumn('tbl_my_campuses',"disp_status", 4 ); } );
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


<div class="col-md-3">
<label>Campus</label>
<select name="disp_campus" id="disp_campus" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($disp_campuses as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>
<div class="col-md-2">
<label>Location</label>
<select name="disp_loc" id="disp_loc" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($disp_locs as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>
<div class="col-md-2">
<label>Status</label>
<select name="disp_status" id="disp_status" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($act_status as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>

<div class="gap gap-small"></div>
</div> 
<a href="account/campus_add" class="btn btn-primary btn-xs"><i class="fa fa-plus-square"></i>Add Campus</a>
<div class="dap gap-mini"></div>
<div class="col-md-12">
<div class="about_header">
<i class="fa fa-book"></i> My Campuses
<hr/>
</div>
<div class="row-fluid">
  <table class="table table-responsive table-bordered table-striped" id="tbl_my_campuses">
    <thead>
      <tr>
        <th>Campus Name</th>
        <th>Campus Email</th>
        <th>Contacts</th>
        <th>Location</th>
        <th>Is Active</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
</div>

</div>



</div>
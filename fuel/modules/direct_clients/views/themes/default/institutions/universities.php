<?php
$conf=$this->fuel->gradstate->config();
$act_status=$conf['yes_no'];
$countries=remove_null_values($this->gradstate_countries_model->options_list('name','name'));
$ins_types=remove_null_values($this->gradstate_institution_types_model->options_list('name','name'));

?>
<script type="text/javascript">
   $(document).ready(function() {		
	oTable = $('#tbl_my_universities').DataTable( {
		"bProcessing": true,
		"bServerSide": true,				
		"sAjaxSource": 'ajax_load/get_my_universities?inst_id=<?=$institution['institution_id']?>',
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
				"mColumns": [ 0, 1,2,3,4 ]
            }
			,
			{
				"sExtends": "csv",
				"sButtonText": "CSV Export",
				"mColumns": [ 0, 1,2,3,4 ]
            }]	},
    } );
	$("#ins_name").keyup( function() { fnFilterColumn('tbl_my_universities',"ins_name", 0 ); } );
	$("#address_disp").keyup( function() { fnFilterColumn('tbl_my_universities',"address_disp", 1 ); } );
	$("#country").change( function() { fnFilterColumn('tbl_my_universities',"country", 2 ); } );
	$("#ins_type").change( function() { fnFilterColumn('tbl_my_universities',"ins_type", 3 ); } );
	$("#disp_status").change( function() { fnFilterColumn('tbl_my_universities',"disp_status", 4 ); } );	
 } );
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
<label>Institution Name</label>
<input name="ins_name" id="ins_name" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>

<div class="col-md-2">
<label>Official Address</label>
<input name="address_disp" id="address_disp" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<div class="col-md-2">
<label>Country</label>
<select name="country" id="country" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($countries as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>
<div class="col-md-2">
<label>Institution Type</label>
<select name="ins_type" id="ins_type" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($ins_types as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>
<div class="col-md-2">
<label>Active</label>
<select name="disp_status" id="disp_status" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($act_status as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>

<div class="gap gap-small"></div>
</div> 
<a href="account/university_add" class="btn btn-primary btn-xs"><i class="fa fa-plus-square"></i>Add University</a>
<div class="dap gap-mini"></div>


<?php if(!empty($universities))
{ ?>
<div class="col-md-12">
<div class="about_header">
<i class="fa fa-building-o"></i> My Universities
<hr/>
</div>
<div class="row-fluid">
  <table class="table table-responsive table-bordered table-striped" id="tbl_my_universities">
    <thead>
      <tr>
        <th>Institution Name</th>
        <th>Official Address</th>
        <th>Country</th>
        <th>Institution Type</th>
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
    <span>Sorry, you have not yet added any international universities on Gradstate.</span>
</div>
<?php }?>
</div>
</div>
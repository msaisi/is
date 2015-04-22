<?php
$conf=$this->fuel->gradstate->config();
$act_status=$conf['yes_no'];
$genders=$conf['genders'];
?>
<script type="text/javascript">
   $(document).ready(function() {		
	oTable = $('#tbl_my_applications').DataTable( {
		"bProcessing": true,
		"bServerSide": true,				
		"sAjaxSource": 'ajax_load/get_my_applications?inst_id=<?=$institution['institution_id']?>',
		"bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayStart ":25,
		 "aoColumns": [
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
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
					"mColumns": [ 0, 1,2,3,4,5,6,7 ]
				}
			,
			{
				"sExtends": "xls",
				"sButtonText": "Excel Export",
				"mColumns": [ 0, 1,2,3,4,5,6,7 ]
            }
			,
			{
				"sExtends": "csv",
				"sButtonText": "CSV Export",
				"mColumns": [ 0, 1,2,3,4,5,6,7 ]
            }]	},
    } );
	$("#ref_no").keyup( function() { fnFilterColumn('tbl_my_applications',"ref_no", 0 ); } );
	$("#course").keyup( function() { fnFilterColumn('tbl_my_applications',"course", 1 ); } );
	$("#f_name").keyup( function() { fnFilterColumn('tbl_my_applications',"f_name", 2 ); } );
	$("#l_name").keyup( function() { fnFilterColumn('tbl_my_applications',"l_name", 3 ); } );
	
	$("#gender").change( function() { fnFilterColumn('tbl_my_applications',"gender", 4 ); } );
	$("#disp_email").keyup( function() { fnFilterColumn('tbl_my_applications',"disp_email", 5 ); } );
	$("#contacts").keyup( function() { fnFilterColumn('tbl_my_applications',"contacts", 6 ); } );	
	$("#disp_date").change( function() { fnFilterColumn('tbl_my_applications',"disp_date", 7 ); } );
	$("#disp_date").keyup( function() { fnFilterColumn('tbl_my_applications',"disp_date", 7 ); } );
	
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


<div class="col-md-2">
<label>Form Serial</label>
<input name="ref_no" id="ref_no" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<div class="col-md-3">
<label>Course Title</label>
<input name="course" id="course" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<div class="col-md-2">
<label>First Name</label>
<input name="f_name" id="f_name" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<div class="col-md-2">
<label>Last Name</label>
<input name="l_name" id="l_name" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<div class="col-md-2">
<label>Gender</label>
<select name="gender" id="gender" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($genders as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>
<div class="col-md-2">
<label>Email</label>
<input name="disp_email" id="disp_email" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<div class="col-md-2">
<label>Contacts</label>
<input name="contacts" id="contacts" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>


<div class="col-md-2">
<label>Download Date</label>
<div id="sandbox-container">
<input name="disp_date" id="disp_date" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
</div>
<div class="gap gap-small"></div>
</div> 

<div class="about_header">
<i class="fa fa-file-o"></i> Application Form Dowloads
<hr/>
</div>
<div class="row-fluid">
  <table class="table table-responsive table-bordered table-striped" id="tbl_my_applications">
    <thead>
      <tr>  
        <th>Form Serial</th>   
        <th>Course Title</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Contacts</th>
        <th>Downlod Date</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
</div>
</div>
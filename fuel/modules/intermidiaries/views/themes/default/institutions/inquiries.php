<?php
$conf=$this->fuel->gradstate->config();
$countries=remove_null_values($this->gradstate_countries_model->options_list('name','name'));
$genders=$conf['genders'];
?>
<script type="text/javascript">
   $(document).ready(function() {		
	oTable = $('#tbl_my_inquiries').DataTable( {
		"bProcessing": true,
		"bServerSide": true,				
		"sAjaxSource": 'ajax_load/get_my_inquiries?inst_id=<?=$institution['institution_id']?>',
		"bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayStart ":10,
		 "aoColumns": [
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": false, "bSearchable": false, "bSortable": false },
			{ "bVisible": false, "bSearchable": false, "bSortable": false },
			{ "bVisible": false, "bSearchable": false, "bSortable": false },
			{ "bVisible": false, "bSearchable": false, "bSortable": false },
			{ "bVisible": false, "bSearchable": false, "bSortable": false },
			{ "bVisible": false, "bSearchable": false, "bSortable": false },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": false, "bSortable": false },
	        ],
		"oLanguage": {
            "sProcessing": "<img src='assets/images/ajax-loader_dark.gif'>"
        },
		"aaSorting": [[5, 'desc']],
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
					"mColumns": [ 0, 1,2,3,4,5,6,7,8,9,10,11 ]
				}
			,
			{
				"sExtends": "xls",
				"sButtonText": "Excel Export",
				"mColumns": [ 0, 1,2,3,4,5,6,7,8,9,10,11 ]
            }
			,
			{
				"sExtends": "csv",
				"sButtonText": "CSV Export",
				"mColumns": [ 0, 1,2,3,4,5,6,7,8,9,10,11 ]
            }]	},
    } );
	$("#f_name").keyup( function() { fnFilterColumn('tbl_my_inquiries',"f_name", 0 ); } );
	$("#l_name").keyup( function() { fnFilterColumn('tbl_my_inquiries',"l_name", 1 ); } );
	
	$("#gender").change( function() { fnFilterColumn('tbl_my_inquiries',"gender", 2 ); } );
	$("#disp_email").keyup( function() { fnFilterColumn('tbl_my_inquiries',"disp_email", 3 ); } );
	$("#country").change( function() { fnFilterColumn('tbl_my_inquiries',"country", 10 ); } );
	$("#inquiry_date").change( function() { fnFilterColumn('tbl_my_inquiries',"inquiry_date", 11 ); } );	
	
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
<label>First Name.</label>
<input name="f_name" id="f_name" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<div class="col-md-2">
<label>Last Name.</label>
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
<label>Email.</label>
<input name="disp_email" id="disp_email" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
<!--<div class="col-md-2">
<label>Contacts.</label>
<input name="contacts" id="contacts" type="text" class="col-md-12 col-xs-12 col-sm-12"/>
</div>
-->
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
<label>Inquiry Date</label>
<div id="sandbox-container">
<input id="inquiry_date" type="text" class="col-md-12 col-xs-12 col-sm-12 filter_select"/>
</div>
</div>


<div class="gap gap-small"></div>
</div> 


<!--<a onclick="javascript:clear_log('< ?=$institution['institution_id']?>','inquiries')" class="btn btn-primary btn-xs"><i class="fa fa-trash-o"></i>Clear Log</a>
<div class="dap gap-mini"></div>-->
<div class="about_header">
<i class="fa fa-question-circle"></i> International University Inquiries
<hr/>
</div>
<div class="row-fluid">
  <table class="table table-responsive table-bordered table-striped" id="tbl_my_inquiries">
    <thead>
      <tr>  
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Email</th> 
        <th>Contacts</th>         
        <th>University Of Interest</th>      
        <th>Country Of Interest</th>       
        <th>Faculty Of Interest</th>
        <th>Nationality</th>
        <th>County</th>
        <th>Country</th>
        <th>Inquiry Date</th> 
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
</div>
</div>
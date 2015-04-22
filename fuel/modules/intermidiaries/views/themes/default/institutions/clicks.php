<?php
$filter=array('institution'=>$institution['institution_id']);
$disp_types=remove_null_values($this->gradstate_clicks_model->options_list('type','type',$filter));
$disp_items=remove_null_values($this->gradstate_clicks_model->options_list('item','item',$filter));
?>
<script type="text/javascript" language="javascript" class="init">
   $(document).ready(function() {		
   tbl_url='ajax_load/get_my_clicks?inst_id=<?=$institution['institution_id']?>';
  	oTable = $('#tbl_my_clicks').dataTable( {		
		"bProcessing": true,
		"bServerSide": true,				
		"sAjaxSource": tbl_url,
		"bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayStart ":25,
		//"bStateSave": true,
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
					//"sPdfOrientation": "landscape",
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
	
	//$("#disp_item").change( function() { fnFilterColumn('tbl_my_clicks',"disp_item", 0 ); } );
	//$("#disp_type").change( function() { fnFilterColumn('tbl_my_clicks',"disp_type", 1 ); } );
	//$("#endDate").change( function() { fnFilterColumn('tbl_my_clicks',"disp_date", 2 ); } );
	//$("#startDate").keyup( function() { fnFilterColumn('tbl_my_clicks',"disp_date", 2 ); } );
	
	$("#apply_filter").click( function() 
	{
		str="";
		itm=$("#disp_item").val().trim();
		typ=$("#disp_type").val().trim();
		end=$("#endDate").val().trim();
		strt=$("#startDate").val().trim();
		
		if(itm!=="")
		{
			str+="&itm="+itm;
		}
		if(typ!=="")
		{
			str+="&typ="+typ;
		}
		if(end!=="")
		{
			str+="&end="+end;
		}
		if(strt!=="")
		{
			str+="&strt="+strt;
		}		
		fnFilterRedraw_table('tbl_my_clicks',tbl_url+str ); 
   });
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
<label>Item</label>
<select name="disp_item" id="disp_item" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($disp_items as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>
<div class="col-md-2">
<label>Type</label>
<select name="disp_type" id="disp_type" class="col-md-12 col-xs-12 col-sm-12 filter_select">                                          
<option value="">Select...</option>
<?php foreach($disp_types as $key=>$val):?>
<option value="<?=$key?>"><?=$val?></option>
<?php endforeach;?>
</select>
</div>
<div class="col-md-3">
<label>Start Date</label>
<div id="sandbox-container">
<input id="startDate" type="text" class="col-md-12 col-xs-12 col-sm-12 filter_select"/>
</div>
</div>
<div class="col-md-3">
<label>End Date</label>
<div id="sandbox-container">
<input id="endDate" type="text" class="col-md-12 col-xs-12 col-sm-12 filter_select"/>
</div>
</div>
<div class="gap gap-mini"></div>
<div class="col-md-12" align="center">
<a id="apply_filter" class="btn btn-primary btn-xs"><i class="fa fa-check-circle-o"></i>Apply Filters</a>
<hr class="gap gap-mini"/>
</div>

<div class="gap gap-small"></div>
</div> 
<a onclick="javascript:clear_log('<?=$institution['institution_id']?>','clicks')" class="btn btn-primary btn-xs"><i class="fa fa-trash-o"></i>Clear Log</a>
<div class="dap gap-mini"></div>
<div class="about_header">
<i class="fa fa-magic"></i> My Clicks
<hr/>
</div>
<div class="row-fluid">
  <table class="table table-responsive table-bordered table-striped" id="tbl_my_clicks">
    <thead>
      <tr>  
        <th>Item</th>  
        <th>Type</th>   
        <th>Log Time</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
</div>
</div>
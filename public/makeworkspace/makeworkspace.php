<!DOCTYPE html>
<html lang="en">
<head>
<?php
	$ruta=  'http://'.$_SERVER['SERVER_NAME'];
?>
    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title> Make a Work Space </title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<script type="text/javascript" charset="utf8" src="<?php echo $ruta;?>/js/jquery/jquery-1.8.2.min.js"></script>
	
	<link rel="stylesheet" href="<?php echo $ruta;?>/assets/bootstrap/css/bootstrap.css">
		  
	<script src="<?php echo $ruta;?>/js/bootstrap.min.js"></script>
		  		  
	<link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/widgets/multi-select/multiselect.css">
	
	<link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/assets/widgets/tooltip/tooltip.css">
		  
	<script type="text/javascript" src="<?php echo $ruta;?>/assets/widgets/multi-select/multiselect.js"></script>
	<script type="text/javascript" src="<?php echo $ruta;?>/js/quicksearch/jquery.quicksearch.js"></script>
	<script type="text/javascript" src="<?php echo $ruta;?>/assets/widgets/tooltip/tooltip.js"></script>
		
<link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>/css/estilo_powerfile.css">


</head>
<body>

<div id="page-title">
    <!--h2>Enter Workspace Data</h2>
    <p></p>
    <div id="theme-options" class="admin-options">
    
    
	</div-->
</div>

<div class="panel">
    <div class="panel-body">
        <h3 class="title-hero">
            &nbsp;
        </h3>
        <div id="fondomodal" class="fondomodal">
				<div id="cargando" class="cargando">
					<img src="<?php echo $ruta;?>/assets/images/spinner/loader-dark.gif" width="100" height="100" alt=""/>
				</div>
		</div>	
        
        <div class="example-box-wrapper">
            <form class="form-horizontal bordered-row">
               <div class="form-group">
                    <label class="col-sm-3 control-label">Workspace Name</label>
                    <div class="col-sm-6">
                        <input type="text" id="workspace" name="workspace" onblur="damenombrebd()" class="form-control popover-button-default" placeholder="Enter the name of the workspace" data-content="Please enter the name of the workspace you want to create" title="Workspace name" data-trigger="focus" data-placement="top">
                    </div>
                </div>
				
				<div class="form-group" style="display:none;">
                    <label class="col-sm-3 control-label">Database Name</label>  
                    <div class="col-sm-6">
                        <input type="text" id="databasename" name="databasename" disabled class="form-control popover-button-default" placeholder="Enter the name of the Database" data-content="Please enter the name of the database that will have the workspace" title="Database name" data-trigger="focus" data-placement="top">
                    </div>
                </div>
				<div class="example-box-wrapper" style="position:relative;text-align: center !important;">
                    <button id="crearws" onclick="crearlo()" class="btn btn-primary active" type="button">Create</button>
                </div>
				
            </form>
        </div>
    </div>
</div>


        </div>
    </div>
</div>
 
<br><br>

</div>



</body>
</html>
<script type="text/javascript">
	function crearlo(){
		var databasename = $('#workspace').val(); $('#databasename').val();
		var workspace = $('#workspace').val();
		if (workspace != '' && databasename != '')
			{
				$('#fondomodal').show();
				var ruta  = '<?php echo $ruta;?>'; 
				var enlacerecep = 'indagador.php';   
				
				$.ajax({
					async:true, 
					type:'post', 
					complete:function(request, json) {   
					  var response1 = request.responseText;   
					  $('#fondomodal').hide();
					  if (response1 == '0')
						{
							alert('Already exists a workspace with that name, please enter a different name');
						}
					 else
						{
							alert('The new workspace was created successfully');
						}	
					  
					  $('#databasename').val('');
					  $('#workspace').val('');
					}, 
					 url:enlacerecep,  
					 data: {ip: 'crearespacios',workspace:workspace,databasename:databasename}
				})
		
			}
	} 
	function damenombrebd(){
		var workspace = $('#workspace').val(); 
		if (workspace != '')
			{
				$('#databasename').val(workspace);
			}
	}
	 

</script>
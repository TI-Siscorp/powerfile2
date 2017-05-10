$(document).ready(function(){

	$("#uploads").click(function(){
		$('#uploadlo').modal('show');
	});
 
	
	//var pagefunction = function() {

       /* Dropzone.autoDiscover = false;
       
        $("#demo-upload").dropzone({
            url: "/logos/upload/",
            addRemoveLinks : true,
            removedfile: function(file) {
            var name = file.name; 

            $.ajax({
                type: 'POST',
                url: '/document/deletetmp/',
                data: "id="+name,
                dataType: 'html'
            });
        },
            maxFilesize: 100,
            dictResponseError: 'Error uploading file!'
        });*/
       
    //};
    //loadScript("/js/dropzone/dropzone.min.js", pagefunction);


    /*Dropzone.autoDiscover = false;
       
        $("#demo-upload").dropzone({
           paramName:'file',
           url: "/logos/create/",
           dictDefaulMessage: "su imagen",
           clickable: true,
           enqueueForUpload : true,
           maxFilesize: 1,
           uploadMultiple: false,
           addRemoveLinks: true
        });*/



});
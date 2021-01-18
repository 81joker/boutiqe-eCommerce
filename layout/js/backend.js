/*
 function detailsmodal(id) {
   var data = {"id" : id};


  jQuery.ajax({

		url:<?=BASEURL; ?>+'backend/include/templates/model.php',
		method : "post",
		data   : data, 

		success: function(data){
		jQuery('body').append(data);
		jQuery('#details-modal').modal('toggle');
		},

		error : function(){
		alert("Something went worng")
		},

  
  });

}
	*/
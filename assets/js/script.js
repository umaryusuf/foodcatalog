$(document).ready(function(){
	var editBtn = $('#editBtn');
	var deleteBtn = $('#deleteBtn');
	var updateForm = $('#updateForm');
	// var likeBtn = $('#likeBtn');
	var changePic = $('#changePic');
	var editInfo = $('#editInfo');


	editBtn.on('click', function(e){
		e.preventDefault();
		deleteBtn.toggle();
		updateForm.toggle();
	});

	changePic.on('click', function(e){
		e.preventDefault();
		$('#changePicForm').toggle();
	});

	editInfo.on('click', function(e){
		e.preventDefault();
		$('#profileInfo').toggle();
		$('#editProfile').toggle();
	});
	
	deleteBtn.on('click', function(e){
		e.preventDefault();
		if(confirm("Are you sure you want to delete this?")){
			window.location.href = deleteBtn.attr('href');
		}
	});

	$('[data-btn-id]').on('click', function(e){
		e.preventDefault();
		window.location.href = $(this).attr('data-to');
	});

	$('[data-toggle="tooltip"]').tooltip();


});
var likeBtn = $('[data-id]');
	likeBtn.on("click", function(e){
	e.preventDefault();
	var btnId = $(this).attr('data-id');
	$.ajax({
	  type: "POST",
	  url: "api/likes?share_id=" + $(this).attr('data-id') + "&user_id=" + $(this).attr('data-user-id'),
	  processData: false,
	  contentType: "application/json",
	  data: '',
	  success: function(r){
		console.log(r);
		var res = JSON.parse(r);
		$("[data-id='" + btnId + "']").html('<i class="fa fa-heart-o"></i> <span class="badge badge-dark">'+ res.Likes +' likes</span>');
	  },
	  error: function(err) {
		console.log(err);
	  }
	});
});
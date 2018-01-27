$(document).ready(function(){
    var editBtn = $('#editBtn');
    var deleteBtn = $('#deleteBtn');
    var updateForm = $('#updateForm');
    var likeBtn = $('#likeBtn');

    editBtn.on('click', function(e){
        e.preventDefault();
        deleteBtn.toggle();
        updateForm.toggle();
    });

    deleteBtn.on('click', function(e){
        e.preventDefault();
        if(confirm("Are you sure you want to delete this?")){
            console.log(true);
            window.location.href = deleteBtn.attr('href');
        }
    });
    
    $('[data-toggle="tooltip"]').tooltip(); 

    likeBtn.on("click", function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "api/likes?share_id=" + $(this).attr('data-id') + "&user_id=" + $(this).attr('data-user-id'),
            processData: false,
            contentType: "application/json",
            data: '',
            success: function(r){
                var res = JSON.parse(r);
                
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

});
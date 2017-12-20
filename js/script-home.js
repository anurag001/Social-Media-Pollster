$(document).ready(function(){
  $("#add-friend").click(function(){
    $("#add-friend").removeClass("btn-success");
      $("#add-friend").addClass("btn-danger");
        $("#add-friend").html("Cancel Request");
  });

  $(".post-likes i").click(function(){
    $(this).toggleClass("active");
  });
});

$(function() {
  $("#Container").mixItUp(), $("#Cols1").click(function() {
    $("#Cols1").addClass("active"), $("#Cols2").removeClass("active"), $("#Cols3").removeClass("active"), $("#Cols4").removeClass("active")
  }), $("#Cols2").click(function() {
    $("#Cols1").removeClass("active"), $("#Cols2").addClass("active"), $("#Cols3").removeClass("active"), $("#Cols4").removeClass("active")
  }), $("#Cols3").click(function() {
    $("#Cols1").removeClass("active"), $("#Cols2").removeClass("active"), $("#Cols3").addClass("active"), $("#Cols4").removeClass("active")
  }), $("#Cols4").click(function() {
    $("#Cols1").removeClass("active"), $("#Cols2").removeClass("active"), $("#Cols3").removeClass("active"), $("#Cols4").addClass("active")
  }), $("#portShow").click(function() {
    $(".portfolio-item-caption").removeClass("d-none")
  }), $("#portHide").click(function() {
    $(".portfolio-item-caption").addClass("d-none")
  })
});

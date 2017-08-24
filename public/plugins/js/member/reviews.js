 //五角星选择
var wjxs = "★";
var wjxn = "☆";
$(".pro-info ul li").mousemove(function () {
    $(this).text(wjxs).prevAll().text(wjxs).end().nextAll().text(wjxn)
      }).mouseleave(function () {
      $(".pro-info ul li").text(wjxn);
   	  $(".clicked").text(wjxs).prevAll().text(wjxs).end().nextAll().text(wjxn)
      }).click(function () {
      $(this).addClass("clicked").siblings().removeClass("clicked")
})


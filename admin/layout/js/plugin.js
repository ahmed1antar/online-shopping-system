$(document).ready(function(){
  
  /* fire select box */
  $("select").selectBoxIt({
    autoWidth : false
  });
  /* initial scroll*/
  $("html").niceScroll();
  /* confirmation message from btn */
  $('.confirm').click(function()
  {
    return confirm("Are You Sure?");
  });

  /* category view option */
  $('.slide').click(function(){
    $(this).next('.full-view').slideToggle();
  });
  
});
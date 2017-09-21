jQuery(document).ready(function($){
  /* Read More shortcode toggles
  ------------------------------ */
  $('.outspoke-readmore').each(function(){
    $(this).readmore({
      collapsedHeight: $(this).data('height'),
      moreLink: '<a href="#">Read More <small>&#9660;</small></a>',
      lessLink: '<a href="#">Show Less <small>&#9650;</small></a>'
    });
  });
});

$(function() {
    if($('.pruduct_slider').length)
    {
    $('.pruduct_slider').jcarousel({
   });
    $('.bx_catalog_tile_slider_arrow_left').jcarouselControl({
            target: '-=1'
        });
        $('.bx_catalog_tile_slider_arrow_right').jcarouselControl({
            target: '+=1'
        });
    }
});
function callbacPhone()
{   
    $.post("/include/callback.php",{},function(data){
        
        $("#modal-callbackPhone").html(data);
    });
     $("#modal-callbackPhone").modal({
         minHeight: 218,
         minWidth: 378
    });
}
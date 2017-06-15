/**
 * Created by Developer on 05.05.14.
 */
$(function(){

    $("#title-search-input").on("focusin",function(){
        $(this).animate({"width":"146px"},200);
        $("#main_menu").animate({"width":"785px"},200);
    });
    $("#title-search-input").on("focusout",function(){
        $(this).animate({"width":"116px"},200);
        $("#main_menu").animate({"width":"815px"},200);
    });
});
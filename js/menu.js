jQuery(document).ready(function($){
    $("#menu-toggle").click(function(e){
        e.preventDefault()
        $(this).parent().eq(0).toggleClass("active")
    })
    $("#custom-menu-2-focus").click(function(e){
        e.preventDefault()
    })
    $("body").removeClass("loading")
    $(".menu-item-has-children").click(function(e){
        e.preventDefault()
        $(this).toggleClass("active")
        $(this).parent().parent().toggleClass("active")
    })
    $("#minimalistflex-menu-focus-hack").focus(function(){
        $("#menu-toggle").focus()
    })
})

$(function (){

'use strict';


$(document).ready(function () {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });


// Switch Between Login and Signup
$('.login-page h1 span').click(function (){
	$(this).addClass('selected').siblings().removeClass('selected');
	$('.login-page form').hide();
	$('.' + $(this).data('class')).fadeIn(100);

});


// Trigger the SelectboxIt
$("select").selectBoxIt({
autowidth:false

});


// Hide placeholder on focus
$('[placeholder]').focus(function () {

$(this).attr('data-text' , $(this).attr('placeholder'));
$(this).attr('placeholder','');

}).blur(function(){
$(this).attr('placeholder',$(this).attr('data-text'));

});


// confirmation Message on button
$('.confirm').click(function(){
	return confirm('Are you sure');
});


});
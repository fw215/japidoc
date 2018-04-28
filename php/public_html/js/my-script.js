$(function () {
	$('.remember-me').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%'
	});
	$('.signup-terms').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%'
	});
});
var base_url = $('#base_url').val();

function showErrorBox() {
	$(".error-box").slideDown('normal', function () {
		$(this).show();
	});
	setTimeout(function () {
		$(".error-box").slideUp('normal', function () {
			$(this).hide();
		});
	}, 2500);
}
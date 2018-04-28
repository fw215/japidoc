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

/**
* アニメーション付きエラー表示
*/
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

/**
* data属性のhrefとidでページ遷移します
* @param {event} MouseEvent
*/
function locationHref(t) {
	href = $(t.target).data('href');
	id = $(t.target).data('id');
	window.location.href = href + id;
}
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
* アニメーション付き成功表示
*/
function showSuccessBox() {
	$(".success-box").slideDown('normal', function () {
		$(this).show();
	});
	setTimeout(function () {
		$(".success-box").slideUp('normal', function () {
			$(this).hide();
		});
	}, 2500);
}

/**
* アニメーション付き警告表示
*/
function showWarningBox() {
	$(".warning-box").slideDown('normal', function () {
		$(this).show();
	});
	setTimeout(function () {
		$(".warning-box").slideUp('normal', function () {
			$(this).hide();
		});
	}, 2500);
}

/**
* data属性のhrefとidでページ遷移します
* @param {event} MouseEvent
*/
function locationHref(t) {
	var href = $(t.target).data('href');
	var id = $(t.target).data('id');

	var project = $(t.target).data('project');
	if (project) {
		window.location.href = href + project + '/' + id;
	} else {
		window.location.href = href + id;
	}
}
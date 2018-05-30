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
 * ページ遷移
 *
 * @param {string} link
 */
var locationHrefMixin = {
	methods: {
		locationHref: function (link) {
			window.location.href = link;
		}
	}
};

Vue.use(vueNotifyjs);
var notificationMixin = {
	data() {
		return {
			notifies: ''
		}
	},
	methods: {
		notification: function (type) {
			var self = this;
			self.$notify({
				message: self.notifies,
				horizontalAlign: 'right',
				verticalAlign: 'bottom',
				type: type,
				timeout: 1000,
			})
		},
		resetNotify: function () {
			var self = this;
			self.notifies = '';
		}
	}
};

/**
 * Benchmarks
 */
var benchmarksMixin = {
	data() {
		return {
			benchmark: {
				benchmark_id: 0,
				env_id: 0,
				times: 0,
			},
			benchmarkErrors: {
				times: null,
			},
			loading: {
				getBENCHMARK: false,
				registerBENCHMARK: false,
			}
		}
	},
	computed: {
		isErrorTimes: function () {
			var self = this;
			if (self.benchmarkErrors.times === null) {
				return false;
			}
			return true;
		},
	},
	methods: {
		getBenchmark: function (benchmark_id) {
			var self = this;
			self.reset();
			self.loading.getBENCHMARK = true;
			axios.get(
				base_url + "api/v1/envs/" + self.env.env_id + "/benchmarks/" + benchmark_id,
			).then(function (res) {
				if (res.data.code == 200) {
					self.benchmark = res.data.benchmark;
				} else {
					self.benchmarkErrors = res.data.errors;
				}
				self.loading.getBENCHMARK = false;
			}).catch(function (error) {
				self.loading.getBENCHMARK = false;
				self.warning.push('取得に失敗しました');
				showWarningBox();
			});
		},
		registerBENCHMARK: function () {
			var self = this;
			self.reset();
			self.loading.registerBENCHMARK = true;
			self.benchmark.env_id = self.env.env_id;
			if (self.benchmark.benchmark_id > 0) {
				axios.put(
					base_url + "api/v1/envs/" + self.env.env_id + "/benchmarks/" + self.benchmark.benchmark_id,
					self.benchmark
				).then(function (res) {
					if (res.data.code == 200) {
					} else {
						self.benchmarkErrors = res.data.errors;
					}
					self.loading.registerBENCHMARK = false;
				}).catch(function (error) {
					self.loading.registerBENCHMARK = false;
					self.warning.push('更新に失敗しました');
					showWarningBox();
				});
			} else {
				axios.post(
					base_url + "api/v1/envs/" + self.env.env_id + "/benchmarks",
					self.benchmark
				).then(function (res) {
					if (res.data.code == 200) {
						self.env.benchmarks = res.data.benchmarks;
						$('#modal-benchmark').modal('hide');
					} else {
						self.benchmarkErrors = res.data.errors;
					}
					self.loading.registerBENCHMARK = false;
				}).catch(function (error) {
					self.loading.registerBENCHMARK = false;
					self.warning.push('登録に失敗しました');
					showWarningBox();
				});
			}
		},
		newBenchmark: function () {
			var self = this;
			self.benchmark = {
				benchmark_id: 0,
				env_id: self.env.api_id,
				times: 0,
			};
		}
	}
}
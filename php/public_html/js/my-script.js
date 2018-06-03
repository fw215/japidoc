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

/**
 * ChartJS
 */
Vue.use(VueChartJs);
Vue.component('line-chart', {
	extends: VueChartJs.Line,
	props: {
		'chart-labels':
			{
				type: Array,
				required: false
			},
		'chart-data':
			{
				type: Array,
				required: false
			},
	},
	mounted() {
		var self = this;
		self.renderChart({
			labels: self.chartLabels,
			datasets: [
				{
					label: 'Data One',
					backgroundColor: '#f87979',
					data: self.chartData
				}
			]
		}, { responsive: true, maintainAspectRatio: false });
	}
});

/**
 * Notification
 */
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
				timeout: 1500,
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
	mixins: [notificationMixin],
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
				self.notifies = '取得に失敗しました';
				self.notification('warning');
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
					self.notifies = '更新に失敗しました';
					self.notification('warning');
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
					self.notifies = '登録に失敗しました';
					self.notification('warning');
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
'use strict';

new Vue({
	el: '#main-container',
	mixins: [notificationMixin, locationHrefMixin],
	data: {
		benchmarks: [],
		chartLabels: [12, 15],
		chartData: [13, 16],
		loading: {
			recent: false,
		},
		errors: {}
	},
	created: function () {
		var self = this;
		self.getRecentBenchmarks();
	},
	methods: {
		getRecentBenchmarks: function () {
			var self = this;
			self.loading.recent = true;
			axios.get(
				base_url + "api/v1/benchmarks/recent"
			).then(function (res) {
				if (res.data.code == 200) {
					self.benchmarks = res.data.benchmarks;
				}
				self.loading.recent = false;
			}).catch(function (error) {
				self.loading.recent = false;
				self.notifies = '取得に失敗しました';
				self.notification('warning');
			});
		},
		setData: function (benchmark) {
			var self = this;
			var result = JSON.parse(benchmark.results);
			self.chartLabels = result.label;
			self.chartData = result.data;
		}
	}
});
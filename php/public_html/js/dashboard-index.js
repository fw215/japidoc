'use strict';

new Vue({
	el: '#main-container',
	mixins: [notificationMixin, locationHrefMixin],
	data: {
		benchmarks: [],
		datacollection: null,
		loading: {
			recent: false,
			getBENCHMARK: false,
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
		setData: function (bench) {
			var self = this;
			self.loading.getBENCHMARK = true;
			axios.get(
				base_url + "api/v1/envs/" + bench.env_id + "/benchmarks/" + bench.benchmark_id,
			).then(function (res) {
				if (res.data.code == 200) {
					var benchmark = res.data.benchmark;
					if (!benchmark.results) {
						self.notifies = 'ベンチマーク実行中';
						self.notification('warning');
					} else {
						var result = JSON.parse(benchmark.results);
						self.datacollection = {
							labels: result.label,
							datasets: [
								{
									label: 'Data',
									backgroundColor: '#f87979',
									data: result.data
								}
							]
						};
					}
				}
				self.loading.getBENCHMARK = false;
			}).catch(function (error) {
				self.loading.getBENCHMARK = false;
				self.notifies = '取得に失敗しました';
				self.notification('warning');
			});
		},
	}
});
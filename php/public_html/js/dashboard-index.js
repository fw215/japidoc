'use strict';

new Vue({
	el: '#main-container',
	mixins: [notificationMixin, locationHrefMixin],
	data: {
		projects: [],
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
					self.projects = res.data.projects;
				}
				self.loading.recent = false;
			}).catch(function (error) {
				self.loading.recent = false;
				self.notifies = '取得に失敗しました';
				self.notification('warning');
			});
		},
	}
});
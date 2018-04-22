'use strict';

new Vue({
	el: '#main-container',
	data: {
		project: {},
		projects: [],
		count: 0,
		search: {
			page: 1,
		},
		executeBox: 0,
		loading: {
			search: false,
			project: false,
		},
	},
	created: function () {
		var self = this;
		self.getProjects();
	},
	computed: {
	},
	watch: {
		'search.page': function (newVal, oldVal) {
			var self = this;
			self.getProjects();
		}
	},
	methods: {
		getSearch: function () {
			var self = this;
			self.search.page = 1;
			self.getProjects();
		},
		getProjects: function () {
			var self = this;
			self.loading.search = true;
			axios.get(
				base_url + "api/v1/projects", {
					params: {
						page: self.search.page,
					}
				}
			).then(function (res) {
				if (res.data.code == 200) {
					self.projects = res.data.projects;
					self.count = res.data.count;
				} else {
					self.error_message = res.data.error;
				}
				self.loading.search = false;
			}).catch(function (error) {
				self.error_message = "通信エラーが発生しました";
				console.log(error);
				self.loading.search = false;
			});
		},
	}
});
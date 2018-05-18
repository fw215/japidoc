'use strict';

new Vue({
	el: '#main-container',
	mixins: [locationHrefMixin],
	data: {
		project: {},
		projects: [],
		pages: 0,
		search: {
			page: 1,
		},
		loading: {
			search: false,
		},
		warning: [],
		errors: {}
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
				base_url + "api/v1/projects/search", {
					params: {
						page: self.search.page,
					}
				}
			).then(function (res) {
				if (res.data.code == 200) {
					self.projects = res.data.projects;
					self.pages = res.data.pages;
				} else {
					self.errors = res.data.errors;
				}
				self.loading.search = false;
			}).catch(function (error) {
				self.loading.search = false;
				self.warning.push('取得に失敗しました');
				showWarningBox();
			});
		},
	}
});
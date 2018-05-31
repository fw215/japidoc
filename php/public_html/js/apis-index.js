'use strict';

new Vue({
	el: '#main-container',
	mixins: [notificationMixin, locationHrefMixin],
	data: {
		api: {},
		apis: [],
		pages: 0,
		search: {
			project_id: 0,
			page: 1,
		},
		loading: {
			search: false,
		},
		errors: {}
	},
	created: function () {
		var self = this;
		self.search.project_id = parseInt($("#project_id").val());
		self.getApis();
	},
	computed: {
	},
	watch: {
		'search.page': function (newVal, oldVal) {
			var self = this;
			self.getApis();
		}
	},
	methods: {
		getSearch: function () {
			var self = this;
			self.search.page = 1;
			self.getApis();
		},
		getApis: function () {
			var self = this;
			self.loading.search = true;
			axios.get(
				base_url + "api/v1/apis/search", {
					params: {
						project_id: self.search.project_id,
						page: self.search.page,
					}
				}
			).then(function (res) {
				if (res.data.code == 200) {
					self.apis = res.data.apis;
					self.pages = res.data.pages;
				} else {
					self.errors = res.data.errors;
				}
				self.loading.search = false;
			}).catch(function (error) {
				self.loading.search = false;
				self.notifies = '取得に失敗しました';
				self.notification('warning');
			});
		},
	}
});
'use strict';

new Vue({
	el: '#main-container',
	data: {
		api: {},
		apis: [],
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
				self.warning.push('取得に失敗しました');
				showWarningBox();
			});
		},
	}
});
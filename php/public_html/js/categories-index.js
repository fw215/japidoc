'use strict';

new Vue({
	el: '#main-container',
	mixins: [notificationMixin, locationHrefMixin],
	data: {
		category: {},
		categories: [],
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
		self.getCategories();
	},
	computed: {
	},
	watch: {
		'search.page': function (newVal, oldVal) {
			var self = this;
			self.getCategories();
		}
	},
	methods: {
		getSearch: function () {
			var self = this;
			self.search.page = 1;
			self.getCategories();
		},
		getCategories: function () {
			var self = this;
			self.resetNotify();
			self.loading.search = true;
			axios.get(
				base_url + "api/v1/categories/search", {
					params: {
						page: self.search.page,
					}
				}
			).then(function (res) {
				if (res.data.code == 200) {
					self.categories = res.data.categories;
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
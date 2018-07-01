'use strict';

new Vue({
	el: '#main-container',
	mixins: [notificationMixin, locationHrefMixin],
	data: {
		scenario: {},
		scenarios: [],
		pages: 0,
		search: {
			project_id: 0,
			freetext: '',
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
		self.getScenarios();
	},
	computed: {
	},
	watch: {
		'search.page': function (newVal, oldVal) {
			var self = this;
			self.getScenarios();
		}
	},
	methods: {
		getSearch: function () {
			var self = this;
			self.search.page = 1;
			self.getScenarios();
		},
		getScenarios: function () {
			var self = this;
			self.loading.search = true;
			axios.get(
				base_url + "api/v1/scenarios/search", {
					params: {
						project_id: self.search.project_id,
						freetext: self.search.freetext,
						page: self.search.page,
					}
				}
			).then(function (res) {
				if (res.data.code == 200) {
					self.scenarios = res.data.scenarios;
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
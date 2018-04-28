'use strict';

new Vue({
	el: '#main-container',
	data: {
		project: {
			project_id: 0,
			name: '',
			description: '',
		},
		loading: {
			get: false,
			register: false
		},
		errors: []
	},
	created: function () {
		var self = this;
		var project_id = parseInt($("#project_id").val());
		if (project_id > 0) {
			self.getProject(project_id);
		}
	},
	methods: {
		registerProject: function () {
			var self = this;

		},
		getProject: function (project_id) {
			var self = this;
			self.loading.get = true;
			axios.get(
				base_url + "api/v1/projects/" + project_id
			).then(function (res) {
				if (res.data.code == 200) {
					self.project = res.data.project;
				} else {
					self.errors = res.data.errors;
				}
				self.loading.get = false;
			}).catch(function (error) {
				self.loading.get = false;
				self.errors.push('取得に失敗しました');
				showErrorBox();
			});
		}
	}
});
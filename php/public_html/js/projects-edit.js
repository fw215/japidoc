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
		errors: {
			name: null,
			description: null
		},
		warning: [],
		successful: [],
		isDangerBox: false
	},
	created: function () {
		var self = this;
		var project_id = parseInt($("#project_id").val());
		if (project_id > 0) {
			self.getProject(project_id);
		}
	},
	computed: {
		isErrorName: function () {
			var self = this;
			if (self.errors.name === null) {
				return false;
			}
			return true;
		},
		isErrorDescription: function () {
			var self = this;
			if (self.errors.description === null) {
				return false;
			}
			return true;
		},
	},
	methods: {
		registerProject: function () {
			var self = this;
			self.reset();
			self.loading.register = true;
			if (self.project.project_id > 0) {
				axios.put(
					base_url + "api/v1/projects/" + self.project.project_id,
					self.project
				).then(function (res) {
					if (res.data.code == 200) {
						self.project = res.data.project;
						self.successful.push('更新しました');
						showSuccessBox();
					} else {
						self.errors = res.data.errors;
					}
					self.loading.register = false;
				}).catch(function (error) {
					self.loading.register = false;
					self.warning.push('更新に失敗しました');
					showWarningBox();
				});
			} else {
				axios.post(
					base_url + "api/v1/projects",
					self.project
				).then(function (res) {
					if (res.data.code == 200) {
						self.project = res.data.project;
						// window.location.href = base_url + "projects/edit/" + self.project.project_id;
						self.successful.push('登録しました');
						showSuccessBox();
					} else {
						self.errors = res.data.errors;
					}
					self.loading.register = false;
				}).catch(function (error) {
					self.loading.register = false;
					self.warning.push('登録に失敗しました');
					showWarningBox();
				});
			}
		},
		deleleProject: function () {
			var self = this;
			self.reset();
			self.loading.delete = true;
			axios.delete(
				base_url + "api/v1/projects/" + self.project.project_id
			).then(function (res) {
				if (res.data.code == 200) {
					self.isDangerBox = false;
					self.project = {
						project_id: 0,
						name: '',
						description: '',
					};
					self.successful.push('削除しました');
					showSuccessBox();
				} else {
					self.errors = res.data.errors;
				}
				self.loading.delete = false;
			}).catch(function (error) {
				self.loading.delete = false;
				self.warning.push('削除に失敗しました');
				showWarningBox();
			});
		},
		getProject: function (project_id) {
			var self = this;
			self.reset();
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
				self.warning.push('取得に失敗しました');
				showWarningBox();
			});
		},
		reset: function () {
			var self = this;
			self.warning = [];
			self.successful = [];
			self.errors = {
				name: null,
				description: null
			};
		}

	}
});
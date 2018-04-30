'use strict';

new Vue({
	el: '#main-container',
	data: {
		api: {
			project_id: 0,
			api_id: 0,
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
		if (!project_id) {
			window.location.href = base_url + "projects";
		}
		self.api.project_id = project_id;
		var api_id = parseInt($("#api_id").val());
		if (api_id > 0) {
			self.getApi(api_id);
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
		registerApi: function () {
			var self = this;
			self.reset();
			self.loading.register = true;
			if (self.api.api_id > 0) {
				axios.put(
					base_url + "api/v1/apis/" + self.api.api_id,
					self.api
				).then(function (res) {
					if (res.data.code == 200) {
						self.api = res.data.api;
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
					base_url + "api/v1/apis",
					self.api
				).then(function (res) {
					if (res.data.code == 200) {
						self.api = res.data.api;
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
		deleleApi: function () {
			var self = this;
			self.reset();
			self.loading.delete = true;
			axios.delete(
				base_url + "api/v1/apis/" + self.api.api_id
			).then(function (res) {
				if (res.data.code == 200) {
					self.isDangerBox = false;
					self.api = {
						project_id: self.api.project_id,
						api_id: 0,
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
		getApi: function (api_id) {
			var self = this;
			self.reset();
			self.loading.get = true;
			axios.get(
				base_url + "api/v1/apis/" + api_id
			).then(function (res) {
				if (res.data.code == 200) {
					self.api = res.data.api;
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
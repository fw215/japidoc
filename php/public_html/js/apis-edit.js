'use strict';

new Vue({
	el: '#main-container',
	data: {
		showBox: 'api',
		env: {
			api_id: 0,
			env_id: 0,
			name: '',
			description: '',
			method: 0,
			url: '',
		},
		envs: [],
		api: {
			project_id: 0,
			api_id: 0,
			name: '',
			description: '',
		},
		loading: {
			getENV: false,
			registerENV: false,
			deleteENV: false,
			getAPI: false,
			registerAPI: false,
			deleteAPI: false,
		},
		errors: {
			name: null,
			description: null,
			method: null,
			url: null
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
		isApi: function () {
			var self = this;
			if (self.showBox !== 'api') {
				return false;
			}
			return true;
		},
		isNewEnv: function () {
			var self = this;
			if (self.showBox !== 'env') {
				return false;
			}
			if (self.env.env_id > 0) {
				return false;
			}
			return true;
		},
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
		isErrorMethod: function () {
			var self = this;
			if (self.errors.method === null) {
				return false;
			}
			return true;
		},
		isErrorUrl: function () {
			var self = this;
			if (self.errors.url === null) {
				return false;
			}
			return true;
		},
	},
	methods: {
		isEnv: function (env_id) {
			var self = this;
			if (self.showBox !== 'env') {
				return false;
			}
			if (env_id !== 0 && self.env.env_id !== env_id) {
				return false;
			}
			return true;
		},
		showEnv: function () {
			var self = this;
			self.showBox = 'env';
		},
		newEnv: function () {
			var self = this;
			self.env = {
				api_id: self.api.api_id,
				env_id: 0,
				name: '',
				description: '',
				method: 0,
				url: '',
			};
			self.showBox = 'env';
		},
		showApi: function () {
			var self = this;
			self.showBox = 'api';
		},
		registerEnv: function () {
			var self = this;
			self.reset();
			self.loading.registerENV = true;
			if (self.env.env_id > 0) {
				axios.put(
					base_url + "api/v1/envs/" + self.env.env_id,
					self.env
				).then(function (res) {
					if (res.data.code == 200) {
						self.env = res.data.env;
						self.getEnvs();
						self.successful.push('更新しました');
						showSuccessBox();
					} else {
						self.errors = res.data.errors;
					}
					self.loading.registerENV = false;
				}).catch(function (error) {
					self.loading.registerENV = false;
					self.warning.push('更新に失敗しました');
					showWarningBox();
				});
			} else {
				axios.post(
					base_url + "api/v1/envs",
					self.env
				).then(function (res) {
					if (res.data.code == 200) {
						self.env = res.data.env;
						self.getEnvs();
						// window.location.href = base_url + "projects/edit/" + self.project.project_id;
						self.successful.push('登録しました');
						showSuccessBox();
					} else {
						self.errors = res.data.errors;
					}
					self.loading.registerENV = false;
				}).catch(function (error) {
					self.loading.registerENV = false;
					self.warning.push('登録に失敗しました');
					showWarningBox();
				});
			}
		},
		getEnv: function (env_id) {
			var self = this;
			self.reset();
			self.showBox = 'env';
			self.loading.getENV = true;
			axios.get(
				base_url + "api/v1/envs/" + env_id
			).then(function (res) {
				if (res.data.code == 200) {
					self.env = res.data.env;
				} else {
					self.errors = res.data.errors;
				}
				self.loading.getENV = false;
			}).catch(function (error) {
				self.loading.getENV = false;
				self.warning.push('取得に失敗しました');
				showWarningBox();
			});
		},
		getEnvs: function () {
			var self = this;
			self.loading.search = true;
			axios.get(
				base_url + "api/v1/envs/search", {
					params: {
						api_id: self.api.api_id,
						page: -1
					}
				}
			).then(function (res) {
				if (res.data.code == 200) {
					self.envs = res.data.envs;
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
		registerApi: function () {
			var self = this;
			self.reset();
			self.loading.registerAPI = true;
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
					self.loading.registerAPI = false;
				}).catch(function (error) {
					self.loading.registerAPI = false;
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
					self.loading.registerAPI = false;
				}).catch(function (error) {
					self.loading.registerAPI = false;
					self.warning.push('登録に失敗しました');
					showWarningBox();
				});
			}
		},
		deleleApi: function () {
			var self = this;
			self.reset();
			self.loading.deleteAPI = true;
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
				self.loading.deleteAPI = false;
			}).catch(function (error) {
				self.loading.deleteAPI = false;
				self.warning.push('削除に失敗しました');
				showWarningBox();
			});
		},
		getApi: function (api_id) {
			var self = this;
			self.reset();
			self.loading.getAPI = true;
			axios.get(
				base_url + "api/v1/apis/" + api_id
			).then(function (res) {
				if (res.data.code == 200) {
					self.api = res.data.api;
					self.getEnvs();
				} else {
					self.errors = res.data.errors;
				}
				self.loading.getAPI = false;
			}).catch(function (error) {
				self.loading.getAPI = false;
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
				description: null,
				method: null,
				url: null
			};
		}

	}
});
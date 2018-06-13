'use strict';

new Vue({
	el: '#main-container',
	mixins: [notificationMixin],
	data: {
		showBox: 'scenario',
		scenario: {
			project_id: 0,
			scenario_id: 0,
			name: '',
			description: '',
		},
		loading: {
			getSCENARIO: false,
			registerSCENARIO: false,
			deleteSCENARIO: false,
		},
		errors: {
			name: null,
			description: null,
		},
		isDangerBox: false
	},
	created: function () {
		var self = this;
		var project_id = parseInt($("#project_id").val());
		if (!project_id) {
			window.location.href = base_url + "projects";
		}
		self.scenario.project_id = project_id;
		var scenario_id = parseInt($("#scenario_id").val());
		if (scenario_id > 0) {
			self.getScenario(scenario_id);
		}
	},
	computed: {
		isScenario: function () {
			var self = this;
			if (self.showBox !== 'scenario') {
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
	},
	methods: {
		registerScenario: function () {
			var self = this;
			self.reset();
			self.loading.registerSCENARIO = true;
			if (self.scenario.scenario_id > 0) {
				axios.put(
					base_url + "api/v1/scenarios/" + self.scenario.scenario_id,
					self.scenario
				).then(function (res) {
					if (res.data.code == 200) {
						self.scenario = res.data.scenario;
						self.notifies = '更新しました';
						self.notification('success');
					} else {
						self.errors = res.data.errors;
					}
					self.loading.registerSCENARIO = false;
				}).catch(function (error) {
					self.loading.registerSCENARIO = false;
					self.notifies = '更新に失敗しました';
					self.notification('warning');
				});
			} else {
				axios.post(
					base_url + "api/v1/scenarios",
					self.scenario
				).then(function (res) {
					if (res.data.code == 200) {
						self.scenario = res.data.scenario;
						self.notifies = '登録しました';
						self.notification('success');
					} else {
						self.errors = res.data.errors;
					}
					self.loading.registerSCENARIO = false;
				}).catch(function (error) {
					self.loading.registerSCENARIO = false;
					self.notifies = '登録に失敗しました';
					self.notification('warning');
				});
			}
		},
		deleleScenario: function () {
			var self = this;
			self.reset();
			self.loading.deleteSCENARIO = true;
			axios.delete(
				base_url + "api/v1/scenarios/" + self.scenario.scenario_id
			).then(function (res) {
				if (res.data.code == 200) {
					self.isDangerBox = false;
					self.scenario = {
						project_id: self.scenario.project_id,
						scenario_id: 0,
						name: '',
						description: '',
					};
					self.notifies = '削除しました';
					self.notification('success');
				} else {
					self.errors = res.data.errors;
				}
				self.loading.deleteSCENARIO = false;
			}).catch(function (error) {
				self.loading.deleteSCENARIO = false;
				self.notifies = '削除に失敗しました';
				self.notification('warning');
			});
		},
		getScenario: function (scenario_id) {
			var self = this;
			self.reset();
			self.loading.getSCENARIO = true;
			axios.get(
				base_url + "api/v1/scenarios/" + scenario_id
			).then(function (res) {
				if (res.data.code == 200) {
					self.scenario = res.data.scenario;
				} else {
					self.errors = res.data.errors;
				}
				self.loading.getSCENARIO = false;
			}).catch(function (error) {
				self.loading.getSCENARIO = false;
				self.notifies = '取得に失敗しました';
				self.notification('warning');
			});
		},
		reset: function () {
			var self = this;
			self.errors = {
				name: null,
				description: null,
			};
			self.benchmarkErrors = {
				times: null,
			};
		}

	}
});
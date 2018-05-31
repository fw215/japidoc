'use strict';

new Vue({
	el: '#main-container',
	mixins: [notificationMixin, locationHrefMixin],
	data: {
		category: {
			category_id: 0,
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
		isDangerBox: false
	},
	created: function () {
		var self = this;
		var category_id = parseInt($("#category_id").val());
		if (category_id > 0) {
			self.getCategory(category_id);
		}
	},
	computed: {
		isErrorName: function () {
			var self = this;
			console.log(self.errors);
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
		registerCategory: function () {
			var self = this;
			self.reset();
			self.loading.register = true;
			if (self.category.category_id > 0) {
				axios.put(
					base_url + "api/v1/categories/" + self.category.category_id,
					self.category
				).then(function (res) {
					if (res.data.code == 200) {
						self.category = res.data.category;
						self.notifies = '更新しました';
						self.notification('success');
					} else {
						self.errors = res.data.errors;
					}
					self.loading.register = false;
				}).catch(function (error) {
					self.loading.register = false;
					self.notifies = '更新に失敗しました';
					self.notification('warning');
				});
			} else {
				axios.post(
					base_url + "api/v1/categories",
					self.category
				).then(function (res) {
					if (res.data.code == 200) {
						self.category = res.data.category;
						self.notifies = '登録しました';
						self.notification('success');
					} else {
						self.errors = res.data.errors;
					}
					self.loading.register = false;
				}).catch(function (error) {
					self.loading.register = false;
					self.notifies = '登録に失敗しました';
					self.notification('warning');
				});
			}
		},
		deleleCategory: function () {
			var self = this;
			self.reset();
			self.loading.delete = true;
			axios.delete(
				base_url + "api/v1/categories/" + self.category.category_id
			).then(function (res) {
				if (res.data.code == 200) {
					self.isDangerBox = false;
					self.category = {
						category_id: 0,
						name: '',
						description: '',
					};
					self.notifies = '削除しました';
					self.notification('success');
				} else {
					self.errors = res.data.errors;
				}
				self.loading.delete = false;
			}).catch(function (error) {
				self.loading.delete = false;
				self.notifies = '削除に失敗しました';
				self.notification('warning');
			});
		},
		getCategory: function (category_id) {
			var self = this;
			self.reset();
			self.loading.get = true;
			axios.get(
				base_url + "api/v1/categories/" + category_id
			).then(function (res) {
				if (res.data.code == 200) {
					self.category = res.data.category;
				} else {
					self.errors = res.data.errors;
				}
				self.loading.get = false;
			}).catch(function (error) {
				self.loading.get = false;
				self.notifies = '取得に失敗しました';
				self.notification('warning');
			});
		},
		reset: function () {
			var self = this;
			self.errors = {
				name: null,
				description: null
			};
		}
	}
});
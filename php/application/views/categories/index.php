
			<section class="content-header">
				<h1>
					<?= lang('categories_title'); ?>
					<small><?= lang('categories_index'); ?></small>
				</h1>
				<ol class="breadcrumb">
					<li>
						<a href="<?= base_url('/categories'); ?>">
							<i class="fa fa-star" aria-hidden="true"></i> <?= lang('categories_title'); ?>
						</a>
					</li>
					<li class="active"><?= lang('categories_index'); ?></li>
				</ol>
			</section>

			<section class="content container-fluid">
				<div class="box">
					<div class="box-header with-border">
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-4">
								<input type="text" class="form-control">
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
								<button class="btn bg-teal"><?= lang('app_search'); ?></button>
							</div>
						</div>
					</div>
					<div class="box-body">
						<div v-if="categories.length > 0" v-cloak>
							<div class="w110px mb20px">
								<select class="form-control input-sm" v-model="search.page">
									<option :value="page" v-for="page in pages">{{page}} <?= lang('app_pages'); ?></option>
								</select>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr class="success">
											<th class="success"><?= lang('categories_id'); ?></th>
											<th><?= lang('categories_name'); ?></th>
											<th class="w90px"><?= lang('categories_created'); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="category in categories">
											<td class="pointer w110px bg-teal" @click="locationHref('<?= base_url('/categories/edit/'); ?>' + category.category_id)">{{category.category_id}}</td>
											<td class="break-word">{{category.name}}</td>
											<td :title="category.created_ymd_his">{{category.created_ymd}}</td>
										</tr>
									</tbody>
									<tfoot>
										<tr class="success">
											<th><?= lang('categories_id'); ?></th>
											<th><?= lang('categories_name'); ?></th>
											<th class="w90px"><?= lang('categories_created'); ?></th>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="w110px">
								<select class="form-control input-sm" v-model="search.page">
									<option :value="page" v-for="page in pages">{{page}} <?= lang('app_pages'); ?></option>
								</select>
							</div>
						</div>
						<div v-else>
							<p class="form-control-static"><?= lang('app_not_exist'); ?></p>
						</div>
					</div>
				</div>
			</section>

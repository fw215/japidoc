
			<section class="content-header">
				<h1>
					<?= $project->name; ?>&ensp;<?= lang('scenarios_title'); ?>
					<small><?= lang('apis_index'); ?></small>
				</h1>
				<ol class="breadcrumb">
					<li>
						<a href="<?= base_url('/projects/edit/').$project->project_id; ?>">
							<i class="fa fa-star" aria-hidden="true"></i> <?= $project->name; ?>
						</a>
					</li>
					<li>
						<a href="<?= base_url('/scenarios/index/').$project->project_id; ?>">
							<i class="fa fa-paper-plane" aria-hidden="true"></i> <?= lang('scenarios_title'); ?>
						</a>
					</li>
					<li class="active"><?= lang('scenarios_index'); ?></li>
				</ol>
			</section>

			<section class="content container-fluid">
				<div class="box">
					<input type="hidden" id="project_id" value="<?= $project->project_id; ?>">
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
						<div v-if="apis.length > 0" v-cloak>
							<div class="w110px mb20px">
								<select class="form-control input-sm" v-model="search.page">
									<option :value="page" v-for="page in pages">{{page}} <?= lang('app_pages'); ?></option>
								</select>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr class="success">
											<th class="success"><?= lang('apis_id'); ?></th>
											<th><?= lang('apis_name'); ?></th>
											<th><?= lang('apis_description'); ?></th>
											<th class="w90px"><?= lang('envs_title'); ?></th>
											<th class="w90px"><?= lang('apis_created'); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="api in apis">
											<td class="pointer w110px bg-teal" @click="locationHref('<?= base_url('/apis/edit/').$project->project_id; ?>/' + api.api_id)">{{api.api_id}}</td>
											<td class="break-word">{{api.name}}</td>
											<td class="break-word">{{api.description}}</td>
											<td><a class="badge bg-maroon pointer" :href="'<?= base_url('/apis/edit/').$project->project_id; ?>/' + api.api_id">{{api.env_count}}</span></td>
											<td :title="api.created_ymd_his">{{api.created_ymd}}</td>
										</tr>
									</tbody>
									<tfoot>
										<tr class="success">
											<th><?= lang('apis_id'); ?></th>
											<th><?= lang('apis_name'); ?></th>
											<th><?= lang('apis_description'); ?></th>
											<th class="w90px"><?= lang('envs_title'); ?></th>
											<th class="w90px"><?= lang('apis_created'); ?></th>
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

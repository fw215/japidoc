
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
							<i aria-hidden="true" class="fa fa-rocket"></i> <?= lang('scenarios_title'); ?>
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
						<div v-if="scenarios.length > 0" v-cloak>
							<div class="w110px mb20px">
								<select class="form-control input-sm" v-model="search.page">
									<option :value="page" v-for="page in pages">{{page}} <?= lang('app_pages'); ?></option>
								</select>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr class="success">
											<th class="success"><?= lang('scenarios_id'); ?></th>
											<th><?= lang('scenarios_name'); ?></th>
											<th><?= lang('scenarios_description'); ?></th>
											<th class="w90px"><?= lang('scenarios_created'); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="scenario in scenarios">
											<td class="pointer w110px bg-teal" @click="locationHref('<?= base_url('/scenarios/edit/').$project->project_id; ?>/' + scenario.scenario_id)">{{scenario.scenario_id}}</td>
											<td class="break-word">{{scenario.name}}</td>
											<td class="break-word">{{scenario.description}}</td>
											<td :title="scenario.created_ymd_his">{{scenario.created_ymd}}</td>
										</tr>
									</tbody>
									<tfoot>
										<tr class="success">
											<th><?= lang('scenarios_id'); ?></th>
											<th><?= lang('scenarios_name'); ?></th>
											<th><?= lang('scenarios_description'); ?></th>
											<th class="w90px"><?= lang('scenarios_created'); ?></th>
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

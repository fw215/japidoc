


			<section class="content-header">
				<h1><?= lang('dashboard_title'); ?></h1>
				<ol class="breadcrumb">
					<li>
						<a href="<?= base_url('/'); ?>">
							<i class="fa fa-paw" aria-hidden="true"></i> <?= lang('dashboard_title'); ?>
						</a>
					</li>
				</ol>
			</section>

			<section class="content container-fluid">
				<div class="callout callout-warning warning-box" v-cloak hidden>
					<h4><i class="icon fa fa-warning"></i> Warning</h4>
					<p><span v-for="warn in warning">{{warn}}<br></span></p>
				</div>

				<div class="box">
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12">
								<h3><?= lang('dashboard_benchmarks'); ?></h3>
								<div class="table-responsive" v-if="projects.length > 0">
									<table class="table table-bordered table-hover">
										<thead>
											<tr class="success">
												<th class="success"><?= lang('projects_id'); ?></th>
												<th><?= lang('projects_name'); ?></th>
												<th><?= lang('projects_description'); ?></th>
												<th class="w90px"><?= lang('apis_title'); ?></th>
												<th class="w90px"><?= lang('envs_title'); ?></th>
												<th class="w90px"><?= lang('projects_created'); ?></th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="project in projects">
												<td class="pointer w110px bg-teal" @click="locationHref('<?= base_url('/projects/edit/'); ?>' + project.project_id)">{{project.project_id}}</td>
												<td class="break-word">{{project.name}}</td>
												<td class="break-word">{{project.description}}</td>
												<td>
													<a :href="'<?= base_url('/apis/edit/'); ?>' + project.project_id + '/' + project.api_id">
														<span class="badge bg-maroon">{{project.api_name}}</span>
													</a>
												</td>
												<td>
													<a :href="'<?= base_url('/apis/edit/'); ?>' + project.project_id + '/' + project.api_id">
														<span class="badge bg-maroon">{{project.env_name}}</span>
													</a>
												</td>
												<td :title="project.created_ymd_his">{{project.created_ymd}}</td>
											</tr>
										</tbody>
										<tfoot>
											<tr class="success">
												<th><?= lang('projects_id'); ?></th>
												<th><?= lang('projects_name'); ?></th>
												<th><?= lang('projects_description'); ?></th>
												<th class="w90px"><?= lang('apis_title'); ?></th>
												<th class="w90px"><?= lang('envs_title'); ?></th>
												<th class="w90px"><?= lang('projects_created'); ?></th>
											</tr>
										</tfoot>
									</table>
								</div>
								<div v-else>
									<p class="form-control-static"><?= lang('benchmarks_not_exist'); ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

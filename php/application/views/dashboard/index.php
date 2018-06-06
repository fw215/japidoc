


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
				<div class="box">
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12">
								<h3><?= lang('dashboard_benchmarks'); ?></h3>
								<div v-if="benchmarks.length > 0" v-cloak>
									<div class="table-responsive">
										<table class="table table-bordered table-hover">
											<thead>
												<tr class="success">
													<th class="success"><?= lang('projects_id'); ?></th>
													<th><?= lang('projects_name'); ?></th>
													<th><?= lang('benchmarks_times'); ?></th>
													<th><?= lang('benchmarks_average'); ?></th>
													<th class="w90px"><?= lang('benchmarks_chart'); ?></th>
													<th><?= lang('apis_title'); ?></th>
													<th><?= lang('envs_title'); ?></th>
													<th class="w90px"><?= lang('projects_created'); ?></th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="benchmark in benchmarks">
													<td class="pointer w110px bg-teal" @click="locationHref('<?= base_url('/projects/edit/'); ?>' + benchmark.project_id)">{{benchmark.project_id}}</td>
													<td class="break-word">{{benchmark.name}}</td>
													<td>{{benchmark.times}}</td>
													<td class="break-word">{{benchmark.average}}</td>
													<td>
														<button type="button" class="btn btn-xs bg-navy" @click="setData(benchmark)">
															<i class="fa fa-area-chart" aria-hidden="true"></i>
														</button>
													</td>
													<td>
														<a :href="'<?= base_url('/apis/edit/'); ?>' + benchmark.project_id + '/' + benchmark.api_id">
															<span class="badge bg-maroon">{{benchmark.api_name}}</span>
														</a>
													</td>
													<td>
														<a :href="'<?= base_url('/apis/edit/'); ?>' + benchmark.project_id + '/' + benchmark.api_id">
															<span class="badge bg-maroon">{{benchmark.category_name}}</span>
														</a>
													</td>
													<td :title="benchmark.created_ymd_his">{{benchmark.created_ymd}}</td>
												</tr>
											</tbody>
											<tfoot>
												<tr class="success">
													<th><?= lang('projects_id'); ?></th>
													<th><?= lang('projects_name'); ?></th>
													<th><?= lang('benchmarks_times'); ?></th>
													<th><?= lang('benchmarks_average'); ?></th>
													<th class="w90px"><?= lang('benchmarks_chart'); ?></th>
													<th><?= lang('apis_title'); ?></th>
													<th><?= lang('envs_title'); ?></th>
													<th class="w90px"><?= lang('projects_created'); ?></th>
												</tr>
											</tfoot>
										</table>
									</div>
									<div v-if="loading.getBENCHMARK">
										<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>
									</div>
									<div v-else>
										<line-chart :height="300" :chart-data="datacollection"></line-chart>
									</div>
								</div>
								<div v-else>
									<p class="form-control-static"><?= lang('benchmarks_not_exist'); ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

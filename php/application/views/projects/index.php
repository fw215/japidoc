
			<section class="content-header">
				<h1>
					<?= lang('projects_title'); ?>
					<small><?= lang('projects_index'); ?></small>
				</h1>
				<ol class="breadcrumb">
					<li>
						<a href="<?= base_url('/projects'); ?>">
							<i class="fa fa-star" aria-hidden="true"></i> <?= lang('projects_title'); ?>
						</a>
					</li>
					<li class="active"><?= lang('projects_index'); ?></li>
				</ol>
			</section>

			<section class="content container-fluid">
				<div class="box">
					<div class="box-header with-border">
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-4">
								検索項目
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
								検索項目
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
								検索項目
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
								検索項目
							</div>
						</div>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr class="success">
										<th><?= lang('projects_id'); ?></th>
										<th><?= lang('projects_name'); ?></th>
										<th><?= lang('projects_description'); ?></th>
										<th class="w90px"><?= lang('projects_created'); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="project in projects">
										<td class="break-word pointer" @click="locationHref" data-href="<?= base_url('/projects/edit/'); ?>" :data-id="project.project_id">
											{{project.project_id}}
										</td>
										<td class="break-word">{{project.name}}</td>
										<td class="break-word">{{project.description}}</td>
										<td :title="project.created_ymd_his">{{project.created_ymd}}</td>
									</tr>
								</tbody>
								<tfoot>
									<tr class="success">
										<th><?= lang('projects_id'); ?></th>
										<th><?= lang('projects_name'); ?></th>
										<th><?= lang('projects_description'); ?></th>
										<th class="w90px"><?= lang('projects_created'); ?></th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</section>

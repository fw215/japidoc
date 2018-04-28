
			<section class="content-header">
				<h1>
					<?= lang('projects_title'); ?>
					<small v-if="project.project_id > 0"><?= lang('projects_edit'); ?></small>
					<small v-else><?= lang('projects_add'); ?></small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?= base_url('/projects'); ?>"><i class="fa fa-star" aria-hidden="true"></i> <?= lang('projects_title'); ?></a></li>
					<li class="active" v-if="project.project_id > 0"><?= lang('projects_edit'); ?></li>
					<li class="active" v-else><?= lang('projects_add'); ?></li>
				</ol>
			</section>

			<section class="content container-fluid">
				<div class="callout callout-warning error-box" v-cloak hidden>
					<h4><i class="icon fa fa-warning"></i> Warning</h4>
					<p><span v-for="err in errors">{{err}}<br></span></p>
				</div>

				<div class="box">
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12">
								<div class="box-body" v-if="loading.get" v-cloak>
									<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>
								</div>
								<div class="box-body" v-else v-cloak>
									<input type="hidden" id="project_id" value="<?= $project_id; ?>">
									<div class="row form-group">
										<label class="col-sm-3 form-control-static"><?= lang('projects_id'); ?></label>
										<div class="col-sm-9 form-control-static">
											<span v-if="project.project_id > 0">{{project.project_id}}</span>
											<span v-else>#</span>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 form-control-static"><?= lang('projects_name'); ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" v-model="project.name">
											<span class="help-block">{{errors.name}}</span>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 form-control-static"><?= lang('projects_description'); ?></label>
										<div class="col-sm-9">
											<textarea class="form-control" rows="5" v-model="project.description"></textarea>
											<span class="help-block">{{errors.description}}</span>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 form-control-static"></label>
										<div class="col-sm-9">
											<button class="btn btn-info" @click="registerProject" v-if="!loading.register">
												<span v-if="project.project_id > 0"><?= lang('projects_edit'); ?></span>
												<span v-else><?= lang('projects_add'); ?></span>
											</button>
											<button class="btn btn-info" v-if="loading.register" disabled><i class="fa fa-spinner fa-pulse fa-fw"></i></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
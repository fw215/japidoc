
			<section class="content-header">
				<h1 v-cloak>
					<?= lang('projects_title'); ?>
					<small v-if="project.project_id > 0"><?= lang('app_edit'); ?></small>
					<small v-else><?= lang('app_add'); ?></small>
				</h1>
				<ol class="breadcrumb" v-cloak>
					<li><a href="<?= base_url('/projects'); ?>"><i class="fa fa-star" aria-hidden="true"></i> <?= lang('projects_title'); ?></a></li>
					<li class="active" v-if="project.project_id > 0"><?= lang('app_edit'); ?></li>
					<li class="active" v-else><?= lang('app_add'); ?></li>
				</ol>
			</section>

			<section class="content container-fluid">
				<div class="box">
					<div class="box-body">
						<div v-if="loading.get" v-cloak>
							<div class="row">
								<div class="col-xs-12">
									<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>
								</div>
							</div>
						</div>
						<div v-else v-cloak>
							<input type="hidden" id="project_id" value="<?= $project_id; ?>">
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"><?= lang('projects_id'); ?></label>
								<div class="col-sm-9 form-control-static">
									<span v-if="project.project_id > 0">{{project.project_id}}</span>
									<span v-else>#</span>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"><?= lang('projects_name'); ?><?= lang('app_required'); ?></label>
								<div class="col-sm-9" :class="{'has-error': isErrorName}">
									<input type="text" class="form-control" v-model="project.name">
									<span class="help-block">{{errors.name}}</span>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"><?= lang('projects_description'); ?></label>
								<div class="col-sm-9" :class="{'has-error': isErrorDescription}">
									<textarea class="form-control" rows="5" v-model="project.description"></textarea>
									<span class="help-block">{{errors.description}}</span>
								</div>
							</div>
							<div class="row form-group" v-if="project.project_id">
								<label class="col-sm-3 form-control-static"><?= lang('apis_title'); ?></label>
								<div class="col-sm-9">
									<button class="btn bg-teal" @click="locationHref('<?= base_url('/apis/index/'); ?>' + project.project_id)">
										<?= lang('apis_index'); ?>&ensp;<span class="badge bg-maroon">{{project.api_count}}</span>
									</button>
								</div>
							</div>
							<div class="row form-group" v-if="project.modified_ymd_his">
								<label class="col-sm-3 form-control-static"><?= lang('projects_modified'); ?></label>
								<div class="col-sm-9 form-control-static">
									{{project.modified_ymd_his}}
								</div>
							</div>
							<div class="row form-group" v-if="project.created_ymd_his">
								<label class="col-sm-3 form-control-static"><?= lang('projects_created'); ?></label>
								<div class="col-sm-9 form-control-static">
									{{project.created_ymd_his}}
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"></label>
								<div class="col-sm-9">
									<button class="btn btn-info" @click="registerProject" v-if="!loading.register">
										<span v-if="project.project_id > 0"><?= lang('app_edit'); ?></span>
										<span v-else><?= lang('app_add'); ?></span>
									</button>
									<button class="btn btn-info" v-else disabled><i class="fa fa-spinner fa-pulse fa-fw"></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="clearfix mb20px" v-cloak>
					<div class="pull-right">
						<button class="btn btn-danger" @click="isDangerBox = !isDangerBox" v-if="project.project_id > 0">
							<i class="fa fa-angle-right" v-if="!isDangerBox"></i>
							<i class="fa fa-angle-down" v-else></i>
							<?= lang('app_delete'); ?>
						</button>
					</div>
				</div>
				<transition>
					<div class="callout bg-red disabled danger-box" v-if="isDangerBox" v-cloak>
						<h4><i class="icon fa fa-ban"></i> Alert</h4>
						<p><?= lang('projects_delete_alert'); ?></p>
						<p class="text-right">
							<button class="btn btn-default"　@click="deleleProject"><?= lang('app_delete'); ?></button>
						</p>
					</div>
				</transition>
			</section>
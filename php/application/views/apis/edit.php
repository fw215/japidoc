
			<section class="content-header">
				<h1 v-cloak>
					<?= lang('apis_title'); ?>
					<small v-if="api.api_id > 0"><?= lang('app_edit'); ?></small>
					<small v-else><?= lang('app_add'); ?></small>
				</h1>
				<ol class="breadcrumb" v-cloak>
					<li>
						<a href="<?= base_url('/projects/edit/').$project->project_id; ?>">
							<i class="fa fa-star" aria-hidden="true"></i> <?= $project->name; ?>
						</a>
					</li>
					<li>
						<a href="<?= base_url('/apis/index/').$project->project_id; ?>">
							<i class="fa fa-paper-plane" aria-hidden="true"></i> <?= lang('apis_title'); ?>
						</a>
					</li>
					<li class="active" v-if="api.api_id > 0"><?= lang('app_edit'); ?></li>
					<li class="active" v-else><?= lang('app_add'); ?></li>
				</ol>
			</section>

			<section class="content container-fluid">
				<div class="callout callout-warning warning-box" v-cloak hidden>
					<h4><i class="icon fa fa-warning"></i> Warning</h4>
					<p><span v-for="warn in warning">{{warn}}<br></span></p>
				</div>
				<div class="callout callout-success success-box" v-cloak hidden>
					<h4><i class="icon fa fa-check"></i> Success</h4>
					<p><span v-for="success in successful">{{success}}<br></span></p>
				</div>

				<div class="box">
					<div class="box-header with-border" v-if="api.api_id > 0">
						<div class="row form-group">
							<div class="col-xs-12">
								<button class="btn bg-maroon" :class="{disabled: isDescription, 'btn-lg': isDescription}" @click="showDescription"><?= lang('app_description'); ?></button>
								<button class="btn bg-orange" :class="{disabled: isNewEnv, 'btn-lg': isNewEnv}"  @click="showNewEnv"><?= lang('apis_add_env'); ?></button>
							</div>
						</div>
					</div>

					<div class="box-body" v-show="isNewEnv">
						<div class="row form-group" v-if="loading.get">
							<div class="col-xs-12">
								<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 form-control-static"><?= lang('envs_name'); ?></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" v-model="env.name">
								<span class="help-block">{{errors.name}}</span>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 form-control-static"><?= lang('envs_description'); ?></label>
							<div class="col-sm-9">
								<textarea class="form-control" rows="5" v-model="env.description"></textarea>
								<span class="help-block">{{errors.description}}</span>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 form-control-static"><?= lang('envs_url'); ?></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" v-model="env.url">
								<span class="help-block">{{errors.url}}</span>
							</div>
						</div>
					</div>

					<div class="box-body" v-show="isDescription" v-cloak>
						<div class="row form-group" v-if="loading.get">
							<div class="col-xs-12">
								<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>
							</div>
						</div>
						<div v-else v-cloak>
							<input type="hidden" id="project_id" value="<?= $project_id; ?>">
							<input type="hidden" id="api_id" value="<?= $api_id; ?>">
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"></label>
								<div class="col-sm-9 form-control-static">
									<?= $project->name; ?>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"><?= lang('apis_id'); ?></label>
								<div class="col-sm-9 form-control-static">
									<span v-if="api.api_id > 0">{{api.api_id}}</span>
									<span v-else>#</span>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"><?= lang('apis_name'); ?><?= lang('app_required'); ?></label>
								<div class="col-sm-9" :class="{'has-error': isErrorName}">
									<input type="text" class="form-control" v-model="api.name">
									<span class="help-block">{{errors.name}}</span>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"><?= lang('apis_description'); ?></label>
								<div class="col-sm-9" :class="{'has-error': isErrorDescription}">
									<textarea class="form-control" rows="5" v-model="api.description"></textarea>
									<span class="help-block">{{errors.description}}</span>
								</div>
							</div>
							<div class="row form-group" v-if="api.modified_ymd_his">
								<label class="col-sm-3 form-control-static"><?= lang('apis_modified'); ?></label>
								<div class="col-sm-9 form-control-static">
									{{api.modified_ymd_his}}
								</div>
							</div>
							<div class="row form-group" v-if="api.created_ymd_his">
								<label class="col-sm-3 form-control-static"><?= lang('apis_created'); ?></label>
								<div class="col-sm-9 form-control-static">
									{{api.created_ymd_his}}
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"></label>
								<div class="col-sm-9">
									<button class="btn btn-info" @click="registerApi" v-if="!loading.register">
										<span v-if="api.api_id > 0"><?= lang('app_edit'); ?></span>
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
						<button class="btn btn-danger" @click="isDangerBox = !isDangerBox" v-if="api.api_id > 0">
							<i class="fa fa-angle-right" v-if="!isDangerBox"></i>
							<i class="fa fa-angle-down" v-else></i>
							<?= lang('app_delete'); ?>
						</button>
					</div>
				</div>
				<transition>
					<div class="callout bg-red disabled danger-box" v-if="isDangerBox" v-cloak>
						<h4><i class="icon fa fa-ban"></i> Alert</h4>
						<p><?= lang('apis_delete_alert'); ?></p>
						<p class="text-right">
							<button class="btn btn-default"　@click="deleleApi"><?= lang('app_delete'); ?></button>
						</p>
					</div>
				</transition>
			</section>
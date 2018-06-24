
			<section class="content-header">
				<h1 v-cloak>
					<?= lang('scenarios_title'); ?>
					<small v-if="scenario.scenario_id > 0"><?= lang('app_edit'); ?></small>
					<small v-else><?= lang('app_add'); ?></small>
				</h1>
				<ol class="breadcrumb" v-cloak>
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
					<li class="active" v-if="scenario.scenario_id > 0"><?= lang('app_edit'); ?></li>
					<li class="active" v-else><?= lang('app_add'); ?></li>
				</ol>
			</section>

			<section class="content container-fluid">
				<div class="box">
					<div class="box-header with-border" v-if="scenario.scenario_id > 0" v-cloak>
						<div class="row form-group">
							<div class="col-xs-12">
								<button class="btn" :class="{'bg-orange': isScenario, 'btn-default': !isScenario}" @click="showScenario"><?= lang('app_description'); ?></button>
								<button class="btn" :class="{'bg-teal': !isScenario, 'btn-default': isScenario}" @click="showScenarios"><?= lang('scenarios_title'); ?></button>
							</div>
						</div>
					</div>

					<div class="box-body" v-show="isScenario" v-cloak>
						<div class="row form-group" v-if="loading.getSCENARIO">
							<div class="col-xs-12">
								<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>
							</div>
						</div>
						<div v-else v-cloak>
							<input type="hidden" id="project_id" value="<?= $project_id; ?>">
							<input type="hidden" id="scenario_id" value="<?= $scenario_id; ?>">
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"></label>
								<div class="col-sm-9 form-control-static">
									<?= $project->name; ?>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"><?= lang('scenarios_id'); ?></label>
								<div class="col-sm-9 form-control-static">
									<span v-if="scenario.scenario_id > 0">{{scenario.scenario_id}}</span>
									<span v-else>#</span>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"><?= lang('scenarios_name'); ?><?= lang('app_required'); ?></label>
								<div class="col-sm-9" :class="{'has-error': isErrorName}">
									<input type="text" class="form-control" v-model="scenario.name">
									<span class="help-block">{{errors.name}}</span>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"><?= lang('scenarios_description'); ?></label>
								<div class="col-sm-9" :class="{'has-error': isErrorDescription}">
									<textarea class="form-control" rows="5" v-model="scenario.description"></textarea>
									<span class="help-block">{{errors.description}}</span>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"><?= lang('scenarios_category'); ?><?= lang('app_required'); ?></label>
								<div class="col-sm-9" :class="{'has-error': isErrorCategory}">
									<select class="form-control" v-model="scenario.category_id">
<?php foreach($categories as $category): ?>
										<option value="<?= $category->category_id; ?>"><?= $category->name; ?></option>
<?php endforeach; ?>
									</select>
									<span class="help-block">{{errors.category_id}}</span>
								</div>
							</div>
							<div class="row form-group" v-if="scenario.modified_ymd_his">
								<label class="col-sm-3 form-control-static"><?= lang('scenarios_modified'); ?></label>
								<div class="col-sm-9 form-control-static">
									{{scenario.modified_ymd_his}}
								</div>
							</div>
							<div class="row form-group" v-if="scenario.created_ymd_his">
								<label class="col-sm-3 form-control-static"><?= lang('scenarios_created'); ?></label>
								<div class="col-sm-9 form-control-static">
									{{scenario.created_ymd_his}}
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"></label>
								<div class="col-sm-9">
									<button class="btn btn-info" @click="registerScenario" v-if="!loading.registerSCENARIO">
										<span v-if="scenario.scenario_id > 0"><?= lang('app_edit'); ?></span>
										<span v-else><?= lang('app_add'); ?></span>
									</button>
									<button class="btn btn-info" v-else disabled><i class="fa fa-spinner fa-pulse fa-fw"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body" v-show="!isScenario" v-cloak>
						<div class="row form-group" v-if="loading.getSCENARIO">
							<div class="col-xs-12">
								<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>
							</div>
						</div>
						<div v-else v-cloak>
							<div class="row form-group">
								<label class="col-sm-3 form-control-static"></label>
								<div class="col-sm-9 form-control-static">
									{{scenario.name}}
								</div>
							</div>
						</div>
					</div>
				</div>

				<div v-show="isScenario">
					<div class="clearfix mb20px" v-cloak>
						<div class="pull-right">
							<button class="btn btn-danger" @click="isDangerBox = !isDangerBox" v-if="scenario.scenario_id > 0">
								<i class="fa fa-angle-right" v-if="!isDangerBox"></i>
								<i class="fa fa-angle-down" v-else></i>
								<?= lang('app_delete'); ?>
							</button>
						</div>
					</div>
					<transition>
						<div class="callout bg-red disabled danger-box" v-if="isDangerBox" v-cloak>
							<h4><i class="icon fa fa-ban"></i> Alert</h4>
							<p><?= lang('scenarios_delete_alert'); ?></p>
							<p class="text-right">
								<button class="btn btn-default"　@click="deleleScenario"><?= lang('app_delete'); ?></button>
							</p>
						</div>
					</transition>
				</div>

			</section>
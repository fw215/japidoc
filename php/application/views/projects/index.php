
			<section class="content-header">
				<h1><?= lang('projects_title'); ?></h1>
				<ol class="breadcrumb">
					<li>
						<a href="<?= base_url('/projects'); ?>">
							<i class="fa fa-paw" aria-hidden="true"></i> <?= lang('projects_title'); ?>
						</a>
					</li>
				</ol>
			</section>

			<section class="content container-fluid">
				<div class="box">
					<div class="box-header with-border">
						<div class="row">
							<div class="col-xs-12">
								<h1>Welcome to CodeIgniter!</h1>
							</div>
						</div>
					</div>
					<div class="box-body">

					<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr class="success">
											<th class="">project</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="project in projects">
											<td>{{project|json}}</td>
										</tr>
									</tbody>
									<tfoot>
										<tr class="success">
											<th class="">project</th>
										</tr>
									</tfoot>
								</table>
							</div>
					</div>
				</div>
			</section>


<?php if($class == 'login' || $class == 'signup'): ?>

<?php else: ?>

		<aside class="main-sidebar">
			<section class="sidebar">
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header"><?= lang('app_aside_header'); ?></li>
					<li class="<?php if(in_array($class, array('dashboard')) && $method == 'index'): ?>active<?php endif; ?>">
						<a href="<?= base_url('/'); ?>">
							<i class="fa fa-tachometer" aria-hidden="true"></i> <span><?= lang('app_aside_dashboard'); ?></span>
						</a>
					</li>
					<li class="treeview <?php if(in_array($class, array('projects','apis'))): ?>active<?php endif; ?>">
						<a href="#"><i class="fa fa-star" aria-hidden="true"></i> <span><?= lang('app_aside_project'); ?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if(in_array($class, array('projects')) && $method == 'index'): ?>active<?php endif; ?>">
								<a href="<?= base_url('/projects'); ?>">
									<?= lang('app_aside_index'); ?>
								</a>
							</li>
							<li class="<?php if(in_array($class, array('projects')) && $method == 'edit'): ?>active<?php endif; ?>">
								<a href="<?= base_url('/projects/edit'); ?>">
									<?= lang('app_aside_edit'); ?>
								</a>
							</li>
<?php if(isset($project)): ?>
							<li class="active bg-maroon">
								<a href="<?= base_url('/projects/edit/').$project->project_id; ?>">
									<i class="fa fa-star" aria-hidden="true"></i> <?= $project->name; ?>
								</a>
							</li>
							<li class="treeview <?php if(in_array($class, array('apis'))): ?>active<?php endif; ?>">
								<a href="#"><i class="fa fa-paper-plane" aria-hidden="true"></i> <span><?= lang('app_aside_api'); ?></span>
									<span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									</span>
								</a>
								<ul class="treeview-menu">
									<li class="<?php if(in_array($class, array('apis')) && $method == 'index'): ?>active<?php endif; ?>">
										<a href="<?= base_url('/apis/index/').$project->project_id; ?>">
											<?= lang('app_aside_index'); ?>
										</a>
									</li>
									<li class="<?php if(in_array($class, array('apis')) && $method == 'edit'): ?>active<?php endif; ?>">
										<a href="<?= base_url('/apis/edit/').$project->project_id; ?>">
											<?= lang('app_aside_edit'); ?>
										</a>
									</li>
								</ul>
							</li>
<?php endif; ?>
						</ul>
					</li>
				</ul>
			</section>
		</aside>

		<div class="content-wrapper">

<?php endif; ?>
			<div class="grid_9">
			<?php if( ! count($projects)): ?>
				<p>You have no projects</p>
			<?php else: ?>
				<ul id="projects-list">
				<?php foreach($projects as $project): ?>
					<li>
						<h3><?php echo HTML::anchor(Route::get('project/general')->uri(array('name' => $project->name)), $project->name) ?></h3>
						<?php echo Text::auto_p(Text::auto_link($project->description)) ?>
						<dl class="inline-actions">
							<dt class="edit"><a href="#">Edit</a></dt>
							<dd class="edit">Edit project</dd>
							<dt class="delete"><a href="#">Delete</a></dt>
							<dd class="delete">Delete project</dd>
						</dl>
						<!--<span class="sub-projects">Sub Projects</span>
						<ul class="sub-projects clearfix">
							<li>
								<a href="#">Another project</a>
								<dl class="inline-actions">
									<dt class="edit"><a href="#">Edit</a></dt>
									<dd class="edit">Edit project</dd>
									<dt class="delete"><a href="#">Delete</a></dt>
									<dd class="delete">Delete project</dd>
								</dl>
							</li>
							<li>
								<a href="#">Another project</a>
								<dl class="inline-actions">
									<dt class="edit"><a href="#">Edit</a></dt>
									<dd class="edit">Edit project</dd>
									<dt class="delete"><a href="#">Delete</a></dt>
									<dd class="delete">Delete project</dd>
								</dl>
							</li>
						</ul>-->
						
					</li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			</div>
			<div class="grid_3">
				<h4>Tags</h4>
			</div>
			<div class="grid_8">
			
				<div id="project-overview">
					<h1><?php echo $project->name ?></h1>
					<?php echo Text::auto_p(Text::auto_link($project->description)) ?>
				</div>
				<div class="activity-feed">
				<?php if( ! count($activities)): ?>
					<p><?php echo __('There are no recent activities in this project'); ?></p>
				<?php else: ?>
					<?php foreach($activities as $activity): ?>
						<div>
							<?php echo $activity->action; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				</div>
			</div>

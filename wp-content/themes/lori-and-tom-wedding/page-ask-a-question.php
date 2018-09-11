<?php
get_header(); 
get_template_part('template-parts/content', 'navigation');
?>

	<div class="content-wrapper">
		<h2>Questions</h2>
		<div class="questions-container">
		<div class="create-question">
			<h3 class="ask-a-question-title">Ask a Question</h3>
			<input class="new-question-input" placeholder="Ask away!">
			<span class="submit-question">Submit</span>
		</div>
		<img class="fancy-section-break" src="<?php echo get_theme_file_uri('/images/section-break.png'); ?>">
		<ul class="questions" id="allQuestions">
			<?php
				$questions = new WP_Query(array(
					'post_type' => 'question',
					'posts_per_page' => -1,
					'post_parent' => 0
				));

				while($questions->have_posts()) {
					$questions->the_post();
					$date = get_the_date('D M y');
					?>
					<li class="question-li" data-id="<?php echo get_the_ID(); ?>">
						<div class="question-wrap">
							<h4 class="question-field"><?php echo esc_attr(get_the_title()); ?></h4>
							<span class="question-meta reply-meta">From <?php the_author(); ?> on <?php echo $date?></span>
								<div class="question-reply-and-buttons">
									<div class="reply-input-cont">
										<input class="reply-input">
										<span class="submit-reply">Submit</span>
									</div>
									<div class="question-buttons">
										<div class="reply-button-cont">
											<span class="reply-question"><i class="fa fa-reply" aria-hidden="true"></i></span>
											<span class="button-desc">
											 	<div class="arrow-notch"></div>
											 	<p class="desc-text">Reply</p>
											</span>
										</div>
										<?php 
										if(get_current_user_id() == get_the_author_meta('ID')) {
									?>
										<div class="edit-button-cont">
											<span class="edit-question"><i class="fa fa-edit" aria-hidden="true"></i></span>
											<span class="button-desc">
											 	<div class="arrow-notch"></div>
											 	<p class="desc-text edit-cancel-text">Edit</p>
											</span>
										</div>
										<div class="delete-button-cont">
											<span class="delete-question"><i class="fa fa-trash-alt" aria-hidden="true"></i></span>
											<span class="button-desc">
											 	<div class="arrow-notch"></div>
											 	<p class="desc-text">Delete</p>
											</span>
										</div>
										<div class="save-button-cont">
											<span class="save-question"><i class="fa fa-upload" aria-hidden="true"></i></span>
											<span class="button-desc">
											 	<div class="arrow-notch"></div>
											 	<p class="desc-text">Save</p>
											</span>
										</div>
										<?php }
										?>
									</div>
							</div>
						</div>
						
						

						<ul class="reply-ul">
						<?php
							$replies = new WP_Query(array(
								'post_type' => 'question',
								'posts_per_page' => -1,
								'post_parent' => get_the_ID()
							));

							while($replies->have_posts()) {
								$replies->the_post();
								$date = get_the_date('D M y');
								?>
								<li class="question-li reply-container" data-id="<?php echo get_the_ID(); ?>">
									<p class="reply-text"><?php the_title(); ?></p>
									<?php 
										if(get_current_user_id() == get_the_author_meta('ID')) {
									?>
									<div class="question-buttons reply-buttons">
										
										<div class="edit-button-cont">
											<span class="edit-reply"><i class="fa fa-edit" aria-hidden="true"></i></span>
											<span class="button-desc">
											 	<div class="arrow-notch"></div>
											 	<p class="desc-text edit-cancel-text">Edit</p>
											</span>
										</div>
										<div class="delete-button-cont">
											<span class="delete-reply"><i class="fa fa-trash-alt" aria-hidden="true"></i></span>
											<span class="button-desc">
											 	<div class="arrow-notch"></div>
											 	<p class="desc-text">Delete</p>
											</span>
										</div>
										<div class="save-button-cont">
											<span class="save-reply"><i class="fa fa-upload" aria-hidden="true"></i></span>
											<span class="button-desc">
											 	<div class="arrow-notch"></div>
											 	<p class="desc-text">Save</p>
											</span>

										</div>
									</div>
									<?php }
								?>
									<div style="width:100%"><span class="reply-meta">From <?php the_author(); ?> on <?php echo $date; ?></span></div>
									<hr>
								</li>
								<?php }
						?>
						</ul>
						<hr class="question-break">
					</li>

				<?php }
			?>
		</ul>
	</div>


<?php get_footer(); 
?>

				<aside>
					<section class="bnr">
						<h2 class="bnr_ttl">運営サイト</h2>
						<figure class="bnr_desc">
							<a href="https://boulgym.com/" target="_blank">
								<img src="<?php bloginfo('template_url'); ?>/assets/img/ban_boulgym.png" alt="首都園近郊ボルダリングジム検索サイト・ボルジム">
							</a>
						</figure>
						<p class="bnr_desc">首都園近郊ボルダリングジム検索サイト・ボルジム / 開発・運営しています。</p>
					</section>

					<section class="popular">
						<h2 class="popular_ttl">人気の記事</h2>



<?php
	// views post metaで記事のPV情報を取得する
	setPostViews(get_the_ID());

	$args = array(
		'meta_key' => 'post_views_count',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'posts_per_page' => 5
	);

	$query = new WP_Query($args);

	//ループ
	if ($query->have_posts()) :
		while ($query->have_posts()) :
			$query->the_post();
?>
						<section class="popular_block">
							<a href="<?php the_permalink(); ?>">
								<figure class="popular_block_fig">
								<?php
									if( has_post_thumbnail() ):
										the_post_thumbnail('full');
									else :
										// no thumbnails
									endif;
								?>
								</figure>
								<h3 class="popular_block_ttl">
									<?php the_title(); ?>
								</h3>
							</a>
						</section>

<?php
		endwhile;
	endif;
	wp_reset_postdata();
?>

					</section>
				</aside>

				<aside>
					<section class="bnr">
						<a href="https://amzn.to/2VWjUyP" target="_blank" rel="noopener noreferrer">
							<img src="<?php bloginfo('template_url'); ?>/assets/img/banner/ff7remake.jpg" alt="FF7 remake"><br>ファイナルファンタジーVII リメイク - Amazonで見る
						</a>
					</section>

					<section class="popular">
						<h2 class="popular_ttl">人気の記事</h2>

<?php
	// views post metaで記事のPV情報を取得する
	$args = array(
		'pagename' => 'about'
	);

	$query = new WP_Query($args);

	//ループ
	if ($query->have_posts()) :
		while ($query->have_posts()) :
			$query->the_post();

			// ACF Documentation - relationship -> https://www.advancedcustomfields.com/resources/relationship/
			$posts = get_field('人気の記事');
			if( $posts ):

				foreach( $posts as $post): // variable must be called $post (IMPORTANT)
					setup_postdata($post);
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
				endforeach;
			endif;
		endwhile;
	endif;
	wp_reset_postdata();
?>

					</section>

					<section class="bnr">
						<h2 class="bnr_ttl">運営サイト</h2>
						<figure class="bnr_desc">
							<a href="https://boulgym.com/" target="_blank">
								<img src="<?php bloginfo('template_url'); ?>/assets/img/ban_boulgym.png" alt="首都園近郊ボルダリングジム検索サイト・ボルジム">
							</a>
						</figure>
						<p class="bnr_desc">首都園近郊ボルダリングジム検索サイト・ボルジム / 開発・運営しています。</p>
					</section>
				</aside>

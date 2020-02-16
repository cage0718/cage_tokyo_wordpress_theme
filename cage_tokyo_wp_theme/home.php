<?php
/*
top page
*/
get_header(); ?>
		<section class="module">
			<div class="container">

				<section class="prime">

					<?php if(have_posts()): while(have_posts()): the_post(); ?>

					<section class="prime_block">
						<a href="<?php the_permalink(); ?>">
							<figure class="prime_block_fig">
								<?php
									if( has_post_thumbnail() ):
										the_post_thumbnail('full');
									else :
										// no thumbnails
									endif;
								?>
							</figure>
						</a>
						<div class="prime_block_info">
							<?php if (!is_category() && has_category()): $prime_cat = get_primary_category(get_the_ID()); ?>
							<span class="prime_block_info_tag">
								<a href="<?php bloginfo('url'); ?>/<?php echo $prime_cat['slug']; ?>">
									<?php
									echo $prime_cat['title'];
									?>
								</a>
							</span>
							<?php endif; ?>
							<time><?php if ($mtime = get_mtime('Y年m月d日')) echo $mtime; else the_time('Y年m月d日'); ?> 更新 / <?php the_time('Y年m月d日'); ?>作成</time>
						</div>
						<a href="<?php the_permalink(); ?>">
							<h2 class="prime_block_ttl"><?php the_title(); ?></h2>
							<p class="prime_block_desc"><?php the_excerpt(); ?></p>
						</a>
					</section>

					<?php endwhile; endif; ?>
					<?php
						// pagination
						if ( function_exists( 'pagination' ) ) :
							pagination( $wp_query->max_num_pages, get_query_var( 'paged' ) );
						endif;
					?>
				</section>

				<?php get_sidebar(); ?>

			</div>
		</section>

<?php get_footer(); ?>
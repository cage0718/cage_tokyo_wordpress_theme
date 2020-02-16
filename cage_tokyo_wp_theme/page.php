<?php
/*
single page
*/
get_header(); ?>
		<section class="module">
			<div class="container">

				<section class="prime">
					<?php if(have_posts()): while(have_posts()): the_post(); ?>
					<article>
						<div class="article_info">
							<?php if (!is_category() && has_category()): $prime_cat = get_primary_category(get_the_ID()); ?>
							<span class="article_info_tag">
								<a href="<?php bloginfo('url'); ?>/<?php echo $prime_cat['slug']; ?>">
									<?php
									echo $prime_cat['title'];
									?>
								</a>
							</span>
							<?php endif; ?>
							<time><?php if ($mtime = get_mtime('Y年m月d日')) echo $mtime; else the_time('Y年m月d日'); ?> 更新 / <?php the_time('Y年m月d日'); ?>作成</time>
						</div>
						<h2 class="article_ttl"><?php the_title(); ?></h2>
						<figure class="article_fig">
							<?php
								if( has_post_thumbnail() ):
									the_post_thumbnail('full');
								else :
									// no thumbnails
								endif;
							?>
						</figure>
						<div class="article_desc">
							<?php the_content(); ?>
						</div>
						<?php endwhile; endif; ?>
					</article>
				<?php
					$related_posts = get_field('関連記事');
					if($related_posts) :
				?>
					<section class="related">
						<h2 class="related_ttl">おすすめ記事</h2>
						<?php
							foreach( $related_posts as $post): // variable must be called $post
							setup_postdata($post);
						?>
						<section class="related_block">
							<a href="<?php the_permalink(); ?>">
								<figure class="related_block_fig">
								<?php
									if( has_post_thumbnail() ):
										the_post_thumbnail('full');
									else :
										// no thumbnails
									endif;
								?>
								</figure>
								<h3 class="related_block_ttl"><?php the_title(); ?></h3>
							</a>
						</section>
						<?php
							endforeach;
							wp_reset_postdata();
						?>
					</section>
					<?php
						endif;
					?>

				</section>

				<?php get_sidebar(); ?>

			</div>
		</section>

<?php get_footer(); ?>
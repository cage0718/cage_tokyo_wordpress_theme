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
						<ul class="article_sns">
							<li class="article_sns_item twitter">
								<a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>-cage.tokyo" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_twitter.svg" alt="Twitterでシェア"></a>
							</li>
							<li class="article_sns_item facebook">
								<a href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_facebook.svg" alt="Facebookでシェア"></a>
							</li>
							<li class="article_sns_item hatebu">
								<a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank" rel="nofollow"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_hatebu.svg" alt="はてなブックマーク"></a>
							</li>
							<li class="article_sns_item pocket">
								<a href="http://getpocket.com/edit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" rel="nofollow" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_pocket.svg" alt="Pocketに保存"></a>
							</li>
						</ul>
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
<?php
/*#########################################################

基本設定

#########################################################*/
// WordPressのバージョンを非表示
remove_action('wp_head','wp_generator');

// 絵文字削除
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles' );
remove_action('admin_print_styles', 'print_emoji_styles');

// excerpt文字変更
function my_excerpt_more($post) {
	return '…';
}
add_filter('excerpt_more', 'my_excerpt_more');

// アイキャッチ有効化
add_theme_support('post-thumbnails');

/*
 * stylesheet.css出力
 */
function read_enqueue_styles() {
	wp_enqueue_style( 'main-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'read_enqueue_styles' );

/*
	最終更新日表示
	参考：http://www.seotemplate.biz/blog/wordpress-tips/4019/
	get_the_modified_time()の結果がget_the_time()より古い場合はget_the_time()を返す。
	同じ場合はnullをかえす。
	それ以外はget_the_modified_time()をかえす。
*/
function get_mtime($format) {
	$mtime = get_the_modified_time('Ymd');
	$ptime = get_the_time('Ymd');
	if ($ptime > $mtime) {
		return get_the_time($format);
	} elseif ($ptime === $mtime) {
		return null;
	} else {
		return get_the_modified_time($format);
	}
}

/*
 * ページ内記事リンク
 */
function related_post($atts) {
	extract(shortcode_atts(array(
			'id' => null
	), $atts));
	$content = '';
	query_posts(array('post_type'=>'post', 'p'=>$id));
	if ( have_posts() ) : while ( have_posts() ) : the_post();
		if (has_post_thumbnail()) {
			$thumbnail_id = get_post_thumbnail_id();
			$eye_img = wp_get_attachment_image_src( $thumbnail_id );
			$thumb_img_url = $eye_img[0];
		}else {
			$thumb_img_url = get_bloginfo('template_directory') . '/img/default.png';
		}
		$content = '<div class="related_link"><a href="' .get_the_permalink() . '">';
		$content .= '<figure class="related_link_fig"><img src="' . $thumb_img_url . '"></figure>';
		$content .= "<div class='related_link_box'>";
		$content .= "<div class='related_link_ttl'>" . get_the_title(). "</div>";
		$content .= "<p class='related_link_desc'>" . get_the_excerpt(). "</p>";
		$content .= "</div></a></div>";
	endwhile; endif;
	wp_reset_query();
	return $content;
}
add_shortcode('related_post', 'related_post');

/*
// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY <?php echo get_primary_category(get_the_ID());?>
// <?php echo '<pre>'.print_r(get_primary_category(get_the_ID()), true).'</pre>'; ?>

複数のカテゴリに所属する記事のメインカテゴリーを表示する方法
https://makotoiwasaki.com/main-category.html
*/
function get_primary_category( $post = 0 ) {
if ( ! $post ) {
$post = get_the_ID();
}
$category = get_the_category( $post );
$primary_category = array();
// If post has a category assigned.
if ($category){
$category_display = '';
$category_slug = '';
$category_link = '';
$category_id = '';

if ( class_exists('WPSEO_Primary_Term') )
{
	// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
	$wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id( $post ) );
	$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
	$term = get_term( $wpseo_primary_term );
	if (is_wp_error($term)) {
		// Default to first category (not Yoast) if an error is returned
		$category_display = $category[0]->name;
		$category_slug = $category[0]->slug;
		$category_link = get_category_link( $category[0]->term_id );
		$category_id = $category[0]->term_id;

	} else {
		// Yoast Primary category
		$category_display = $term->name;
		$category_slug = $term->slug;
		$category_link = get_category_link( $term->term_id );
		$category_id = $term->term_id;
	}
}
else {
	// Default, display the first category in WP's list of assigned categories
	$category_display = $category[0]->name;
	$category_slug = $category[0]->slug;
	$category_link = get_category_link( $category[0]->term_id );
	$category_id = $term->term_id;
}
$primary_category['url'] = $category_link;
$primary_category['slug'] = $category_slug;
$primary_category['title'] = $category_display;
$primary_category['id'] = $category_id;

}
//return $category_display;
return $primary_category;
}

// 人気記事出力用
// 『プラグインなし』で人気記事一覧を出力する方法【WordPress】・manablog
// https://manablog.org/wordpress-popular-posts-without-plugin/
function getPostViews($postID){
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "0 View";
	}
	return $count.' Views';
}
function setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
	}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
	}
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/**
* ページネーション出力関数
* $paged : 現在のページ
* $pages : 全ページ数
* $range : 左右に何ページ表示するか
* $show_only : 1ページしかない時に表示するかどうか

WordPressでページャー（ページネーション）をプラグインなしで実装
https://wemo.tech/978
*/
function pagination( $pages, $paged, $range = 2, $show_only = false ) {

	$pages = ( int ) $pages;    //float型で渡ってくるので明示的に int型 へ
	$paged = $paged ?: 1;       //get_query_var('paged')をそのまま投げても大丈夫なように

	//表示テキスト
	$text_first   = "« 最初へ";
	$text_before  = "‹ 前のページ";
	$text_next    = "次のページ ›";
	$text_last    = "最後へ »";

	if ( $show_only && $pages === 1 ) {
		// １ページのみで表示設定が true の時
		echo '<div class="pagination"><span class="current pager">1</span></div>';
		return;
	}

	if ( $pages === 1 ) return;    // １ページのみで表示設定もない場合

	if ( 1 !== $pages ) {
		//２ページ以上の時
		echo '<div class="pagination">';
		// if ( $paged > $range + 1 ) {
		// 	// 「最初へ」 の表示
		// 	echo '<a href="', get_pagenum_link(1) ,'" class="pager first">', $text_first ,'</a>';
		// }
		if ( $paged > 1 ) {
			// 「前へ」 の表示
			echo '<a href="', get_pagenum_link( $paged - 1 ) ,'" class="pager prev">', $text_before ,'</a>';
		}
		for ( $i = 1; $i <= $pages; $i++ ) {

			if ( $i <= $paged + $range && $i >= $paged - $range ) {
				// $paged +- $range 以内であればページ番号を出力
				if ( $paged === $i ) {
					echo '<span class="current pager">', $i ,'</span>';
				} else {
					echo '<a href="', get_pagenum_link( $i ) ,'" class="pager">', $i ,'</a>';
				}
			}
		}
		if ( $paged < $pages ) {
			// 「次へ」 の表示
			echo '<a href="', get_pagenum_link( $paged + 1 ) ,'" class="pager next">', $text_next ,'</a>';
		}
		// if ( $paged + $range < $pages ) {
		// 	// 「最後へ」 の表示
		// 	echo '<a href="', get_pagenum_link( $pages ) ,'" class="pager last">', $text_last ,'</a>';
		// }
		echo '</div>';
	}
}

// カテゴリーrewrite
//「WordPress でカテゴリーアーカイブのURLに /category を入れたくない問題を力技で解決する」hi3103の備忘録
// https://hi3103.net/notes/web/1329
function custom_rewrite_basic() {
	//パイプ区切りのカテゴリーリスト作成
	$cats = get_categories( $args );
	$args = array(
		'hide_empty' => 0,
		'taxonomy' => 'category',
	);
	$catList = '';
	$i = 0;
	foreach ($cats as $cat) {
		if($i!=0){ $catList .= '|'; }
		$catList .= $cat->slug;
		$i++;
	}
	$catList = '('.$catList.')';
	//リライトルールを追加
	add_rewrite_rule($catList.'/feed/(feed|rdf|rss|rss2|atom)/?$', 'index.php?category_name=$matches[1]&feed=$matches[2]', 'top');
	add_rewrite_rule($catList.'/(feed|rdf|rss|rss2|atom)/?$', 'index.php?category_name=$matches[1]&feed=$matches[2]', 'top');
	add_rewrite_rule($catList.'/embed/?$', 'index.php?category_name=$matches[1]&embed=true', 'top');
	add_rewrite_rule($catList.'/page/?([0-9]{1,})/?$', 'index.php?category_name=$matches[1]&paged=$matches[2]', 'top');
	add_rewrite_rule($catList.'/?$', 'index.php?category_name=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_basic');
<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package yanapu
 */

get_header();
?>

<main id="primary" class="site-main col-md-8">

	<?php if (have_posts()) : ?>

		<header class="page-header">
			<h1>ヤナぷー日記</h1>

			<?php $terms = get_terms('category_diary'); ?>
			<ul class="nav">
				<?php foreach ($terms as $term): ?>
					<li class="nav-item"><a class="nav-link" href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term -> name); ?></a></li>
				<?php endforeach; ?>
			</ul>

            <h2><?php the_archive_title(); ?></h2>
		</header><!-- .page-header -->

		<ul>
			<?php
			/* Start the Loop */
			while (have_posts()) :
				the_post();

			?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php
			endwhile;
			?>
		</ul>
	<?php
		the_posts_navigation();

	else :

		get_template_part('template-parts/content', 'none');

	endif;
	?>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();

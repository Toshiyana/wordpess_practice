<p>日記タイトル： <?php the_title(); ?></p>

<?php $price = get_post_meta(get_the_ID(), '費用', true); //trueとすると文字列を返す
?>
<?php $ingredient = get_post_meta(get_the_ID(), '材料', false); //falseとすると配列を返す
?>
<dl>
    <?php if ($price !== '') : ?>
        <dt>費用</dt>
        <dd><?php echo esc_html(number_format($price)); ?> 円</dd>
    <?php endif; ?>

    <?php if ($ingredient) : ?>
        <dt>材料</dt>
        <?php foreach ($ingredient as $ing) : ?>
            <dd><?php echo esc_html($ing); ?></dd>
        <?php endforeach; ?>
    <?php endif; ?>

</dl>
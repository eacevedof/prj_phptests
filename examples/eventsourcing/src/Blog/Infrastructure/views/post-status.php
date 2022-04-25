<?php
/**
 * @var App\Blog\Domain\PostEntity $post;
 */
?>
<h1>Post status: <?=$post->status()->value() ? "Published" : "Not published"?></h1>
<h2><?=$post->title()->value()?></h2>
<p>
<?=$post->content()->value()?>
</p>
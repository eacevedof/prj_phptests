<?php
/**
 * @var App\Publishing\Domain\PostEntity $post;
 */
?>
<h1>Post status: <?=$post->status() ? "Published" : "Not published"?></h1>
<h2><?=$post->title()?></h2>
<p>
<?=$post->content()?>
</p>
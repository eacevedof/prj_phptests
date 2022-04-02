<?php
/**
 * @file: ddd_post_publishing.php
 * @info: [Rigor Talks - Playlist](https://www.youtube.com/watch?v=aKcmbOZV9mA&list=PLfgj7DYkKH3Cd8bdu5SIHGYXh_bPV2idP&index=1)
 */
include_once(TFW_PATHROOTDS."vendor/autoload.php");
include_once("app/bootstrap.php");

use App\Publishing\Infrastructure\PostController;
(new PostController())->publish();
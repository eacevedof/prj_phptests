<?php
/**
 * @file: ddd_post_publishing.php
 * @info: [Rigor Talks - Playlist](https://www.youtube.com/watch?v=aKcmbOZV9mA&list=PLfgj7DYkKH3Cd8bdu5SIHGYXh_bPV2idP&index=1)
 */
include_once("src/autoload.php");
include_once("src/config/listeners/commands.php");
include_once("src/config/listeners/events.php");

use App\Blog\Infrastructure\PostController;
use App\Shared\Infrastructure\Bus\CommandBus;

(new PostController(CommandBus::instance()))->publish();
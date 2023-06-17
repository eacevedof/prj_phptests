<?php

namespace DesignPatterns\Upm\Composite;

use DesignPatterns\Upm\Composite\Node;
use DesignPatterns\Upm\Composite\Number;
use DesignPatterns\Upm\Composite\TheTree;

final class ClsMain
{
    public static function main(Array $arArgs=[])
    {
        $theTree = TheTree::fromPrimitives();
        $number = Number::getNumber(5);
        $theTree->addNumber($number);
        $node = Node::getNode("one");
        $node->addNumber(7);
        $node->addNumber(8);
        $node->addNode(
            Node::getNode()
        );
        $theTree->addNode($node);
    }
}
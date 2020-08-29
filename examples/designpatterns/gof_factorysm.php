<?php
/**
 * @file: gof_factorysm.php
 * @info: SourceMaking.com https://sourcemaking.com/design_patterns/factory_method/php/1
 */
include(TFW_PATHROOTDS."vendor/autoload.php");

use DesignPatterns\Gof\factorySM\OReillyFactoryMethod;
use DesignPatterns\Gof\factorySM\SamsFactoryMethod;

writeln("<pre>");
writeln("START TESTING FACTORY METHOD PATTERN");
writeln("");

writeln("testing OReillyFactoryMethod");
$oFactoryMethod = new OReillyFactoryMethod;
testFactoryMethod($oFactoryMethod);
writeln("");

writeln("testing SamsFactoryMethod");
$oFactoryMethod = new SamsFactoryMethod;
testFactoryMethod($oFactoryMethod);
writeln("");

writeln("END TESTING FACTORY METHOD PATTERN");
writeln("");

function testFactoryMethod($oFactoryMethod) 
{
    $oBook = $oFactoryMethod->makePHPBook("us");
    writeln("us php Author: ".$oBook->getAuthor());
    writeln("us php Title: ".$oBook->getTitle());

    $oBook = $oFactoryMethod->makePHPBook("other");
    writeln("other php Author: ".$oBook->getAuthor());
    writeln("other php Title: ".$oBook->getTitle());

    $oBook = $oFactoryMethod->makePHPBook("otherother");
    writeln("otherother php Author: ".$oBook->getAuthor());
    writeln("otherother php Title: ".$oBook->getTitle());
}//testFactoryMethod

function writeln($sLine) {echo $sLine."<br/>";}     

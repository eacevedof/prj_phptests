```php
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Form\Input\Checkbox;

//https://www.w3schools.com/tags/att_input_checked.asp
$o = new Checkbox();
$o->set_name("chkSome");
$o->set_unlabeled(0); //incluye el texto visible dentro de una etiqueta
$o->set_options(["valbike"=>"Bike","valcar"=>"Car"]);
$o->show();
```

```php
use TheFramework\Helpers\Form\Input\Date;

$o = new Date("someId");
$o->set_value("06-12-2018");//ok
$o->set_value("2018-12-06");//ok
$o->set_value("20181206");//bad!
$o->set_value("06122018");//bad!
$o->set_value("06/12/2018");//ok
$o->show();
```

```php
use TheFramework\Helpers\Form\Input\File;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someId");
$oL->set_innerhtml("This is an Input File:");
$o = new File("someId","someName",NULL,$oL);
$o->set_accept("image/png, image/jpeg");
$o->add_extras("multiple","multiple");
$o->show();
```

```php
use TheFramework\Helpers\Form\Input\Hidden;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someId");
$oL->set_innerhtml("Field hidden is here:");
$oL->show();
$o = new Hidden("someId","someName","her-comes-a-token-to-be-hidden-afdoopjy8679834ñoñ$$34878=?dsjk");
$o->show();
$o = new Hidden();
$o->set_id("someId2");
$o->set_name("someName2");
$o->set_value("this-is-a-date: 2018-12-08 09:02:00");
$o->show();
```

```php
use TheFramework\Helpers\Form\Input\Password;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someId");
$oL->set_innerhtml("Type your password her:");
$oL->show();

$o = new Password("someId","someName","mySecretKey",20);
$o->add_style("border:1px solid rgb(255,0,0)");
$o->add_style("color:blue");
$o->show();
```

```php
use TheFramework\Helpers\Form\Input\Radio;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someRadio");
$oL->set_innerhtml("Choose one value: ");
$oL->show();

$o = new Radio(["key-1"=>"val-1","key-2"=>"val-2","key-3"=>"val-3"],"myRadioGroup");
$o->show();
``` 

```php
use TheFramework\Helpers\Form\Input\Text;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someTextId");
$oL->set_innerhtml("Set a value:");

$o = new Text("someTextId","someName");
$o->set_label($oL);
$o->add_extras("placeholder"," this is placeholder");
$o->show();
```

```php
//Example: https://developer.mozilla.org/es/docs/Web/HTML/Elemento/fieldset
use TheFramework\Helpers\Form\Form;
use TheFramework\Helpers\Form\Fieldset;
use TheFramework\Helpers\Form\Legend;
use TheFramework\Helpers\Form\Input\Text;
use TheFramework\Helpers\Form\Label;

(new Form())->show_opentag();
$oFs = new Fieldset();
$oLeg = new Legend("Información Personal");

$oLbl1 = new Label();
$oLbl1->set_innerhtml("Nombre:");
$oTxt1 = new Text("nombre","nombre");
$oTxt1->add_extras("tabindex","1");
$oTxt1->set_label($oLbl1);

$oLbl2 = new Label();
$oLbl2->set_innerhtml("Apellidos:");
$oTxt2 = new Text("nombre","nombre");
$oTxt2->add_extras("tabindex","2");
$oTxt2->set_label($oLbl2);

$oFs->add_inner_object($oLeg);
$oFs->add_inner_object($oTxt1);
$oFs->add_inner_object($oTxt2);
$oFs->show();
(new Form())->show_closetag();
```

```php
//Example: https://developer.mozilla.org/es/docs/Web/HTML/Elemento/form
use TheFramework\Helpers\Form\Form;
use TheFramework\Helpers\Form\Input\Text;
use TheFramework\Helpers\Form\Input\Generic;
use TheFramework\Helpers\Form\Label;

/*
($id="", $name="", $method="post", $innerhtml=""
,$action="", $class="", $style="", $arExtras=array(), $enctype="", $onsubmit="")
*/
$oForm = new Form("SomeFormId");
$oForm->set_method("post");
$oLabel = new Label("POST-name","Nombre:");
$oTxt = new Text("POST-name","name");
$oTxt->set_label($oLabel);
$oButton = new Generic("Save");
$oButton->add_extras("type","submit");
$oForm->add_control($oTxt);
$oForm->add_control($oButton);
$oForm->show();
```

```php
use TheFramework\Helpers\Form\Form;
use TheFramework\Helpers\Form\Select;
use TheFramework\Helpers\Form\Input\Generic;
use TheFramework\Helpers\Form\Label;

/*
($id="", $name="", $method="post", $innerhtml=""
,$action="", $class="", $style="", $arExtras=array(), $enctype="", $onsubmit="")
*/
$oForm = new Form("SomeFormId");
$oForm->set_method("post");
$oLabel = new Label("POST-name","Select one:");
$oSelect = new Select([""=>"...","key1"=>"Txt 1","key2"=>"Txt 2","key3"=>"Txt 3","key4"=>"Txt 4"]);
$oSelect->set_label($oLabel);
//$oSelect->set_value_to_select("key3"); autoselect by key
//$oSelect->readonly(); //autoselect by key and removes other keys
$oButton = new Generic("Save");
$oButton->add_extras("type","submit");
$oForm->add_control($oSelect);
$oForm->add_control($oButton);
$oForm->show();
```

```php
use TheFramework\Helpers\Form\Form;
use TheFramework\Helpers\Form\Textarea;
use TheFramework\Helpers\Form\Input\Generic;
use TheFramework\Helpers\Form\Label;

$oForm = new Form("SomeFormId");
$oForm->set_method("post");
$oLabel = new Label("idTextarea","Type your article:");
$oTextarea = new Textarea("idTextarea","nameTextarea");
$oTextarea->set_innerhtml("this is an example text");
$oTextarea->add_extras("autofocus");
$oTextarea->set_label($oLabel);
$oTextarea->set_maxlength(25);
//$oTextarea->set_counterspan(); //activa render de <span> contador </span>
//renderiza js que gestiona maxlength y actualiza span contador, tiene que estar activado counterspan
//$oTextarea->set_counterjs();
//$oTextarea->readonly();
$oButton = new Generic("Save");
$oButton->add_extras("type","submit");
$oForm->add_control($oTextarea);
$oForm->add_control($oButton);
$oForm->show();
```

```php
use TheFramework\Helpers\Html\Table\Raw;

$arData = [
    0=>["col0"=>"val_r0_col_0"
    ,"col1"=>"val_r0_col_1"
    ,"col2"=>"val_r0_col_2"],
    1=>["col0"=>"val_r1_col_0"
    ,"col1"=>"val_r1_col_1"
    ,"col2"=>"val_r1_col_2"],
    2=>["col0"=>"val_r2_col_0"
    ,"col1"=>"val_r2_col_1"
    ,"col2"=>"val_r2_col_2"]    
];

$arLabel = ["colName0" ,"colName1" ,"colName2"];

//$oHlpTable = new Raw($arData); //works fine
$oHlpTable = new Raw($arData,$arLabel);
$oHlpTable->show();
```

```php
use TheFramework\Helpers\Html\Table\Tr;
use TheFramework\Helpers\Html\Table\Td;
use TheFramework\Helpers\Html\Table\Table;

$arData = [
    0 => ["col0"=>"val_r0_col_0","col1"=>"val_r0_col_1","col2"=>"val_r0_col_2"],
    1 => ["col0"=>"val_r1_col_0","col1"=>"val_r1_col_1","col2"=>"val_r1_col_2"],
    2 => ["col0"=>"val_r2_col_0","col1"=>"val_r2_col_1","col2"=>"val_r2_col_2"]    
];

$arLabel = ["colName0" ,"colName1" ,"colName2"];

$arTrs = [];

$oTr = new Tr();
foreach($arLabel as $sLabel)
{
    $oTh = new Td();
    $oTh->set_type("th");
    $oTh->set_comments(" this is a comment before Th");
    $oTh->set_js_onclick("alert('clicked on {$sLabel}')");
    $oTh->set_innerhtml($sLabel);
    $oTr->add_td($oTh);
}
$arTrs[] = $oTr;

foreach($arData as $iRow=>$arRow)
{
    $oTr = new Tr();
    $oTr->set_attr_rownumber($iRow);
    foreach($arRow as $sFieldName=>$sFieldValue)
    {
        $oTd = new Td();
        if($iRow==0)
            $oTd->add_style("border:1px solid red");
        elseif($iRow==1)
            $oTd->add_style("border:1px solid green");
        else
            $oTd->add_style("border:1px solid blue");

        $oTd->set_attr_rownumber($iRow);
        $oTd->set_attr_colnumber($sFieldName);
        $oTd->set_innerhtml($sFieldValue);
        $oTr->add_td($oTd);
    }
    $arTrs[] = $oTr;
}//foreach


//$oHlpTable = new Raw($arData); //works fine
$oHlpTable = new Table($arTrs,"someTblId");
$oHlpTable->add_style("background:#cccccc");
$oHlpTable->add_style("border:1px dashed #FF0000");
$oHlpTable->show();
```

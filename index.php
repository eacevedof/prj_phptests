<?php
//carga el loader de composer. Este loader solo tiene registrado el loader de helpers.
require_once "vendor/autoload.php";
//$oRaw = new Theframework\Helpers\HelperRaw("<p>hello</p>");
//$oRaw->show();
//use Theframework\Helpers\HelperDiv;
//$oDiv = new HelperDiv();
//$oDiv->set_innerhtml("some div");
//$oDiv->show();


require_once "vendor/theframework/components/autoload.php";

use TheFramework\Components\ComponentExtract;
$oComp = new ComponentExtract();
$oComp->run();
$arLines = $oComp->get_extracted();
$arLines = array_unique($arLines);
asort($arLines);
bug($arLines);

$sSQLIn = implode("','",$arLines);
$sSQLIn = "('$sSQLIn')";

print_r($sSQLIn);

/*FCABPED
select distinct tabla,a_erptabla
from ERP_Taules_Telynet
where tabla in ('AAA','ABGRU','ABTNR','ALAND','ANRED','AUART','AUGRU','AUT','BANKL','BANKN','BANKS','BELNR','BEZEI','BORRADO TABLAS ERP_XXX','BRGEW','BUKRS','BUTXT','BUZEI','BZIRK','CITYC','CLASEATR','CLASECON','CODEST','CONFIG','CONFIG - ERP_auxiliar','CTLPC','DATAB','DATBI','DEFECTO','DOANZA','DOANZF','ERDAT','ERSDA','FAGEDH','FAGEEM','FAGEMA','FAGENT','FALERT','FARTER','FARTER - ERP_auxiliar','FATRDS','FATRDS - ERP_auxiliar','FATRIB','FATRIB - ERP_auxiliar','FATRVA','FATRVA - ERP_auxiliar','FCLIDF','FCLIIN','FCLIPV','FCLITI','FCLIVP','FCPAVEN','FECDOC','FECHA','FGESTI','FPLRUT','FTIIVA','FTRANS','FVPSOC','GEWEI','GJAHR','HKUNNR','HORA','IDNRK','IMPNO','INCO1','INCO2','IVEN30D','IVEN60D','IVEN90D','IVENMAS','IVENRIE','ImportFlamagas','Importación XNT Flamagas','KDGRP','KLIMK','KNA1','KNB1','KNBK','KNVH','KNVP','KNVPBIS','KNVV','KONDA','KOSTL','KSCHL','KTEXT','KTOKD','KTOPL','KUNN2','KUNNR','LAEDA','LAND1','LANDX','LANGU','LGOBE','LGORT','LIFNR','LIFNR2','LINCA','LPRIO','LZONE','MAKT','MAKTX','MARA','MARCA','MATKL','MATNR','MEINS','MENGE','MLAN','MTART','MTPOS','MVKE','NAME1','NAME2','NAME3','NAME4','NTGEW','NUMORD','OBLIG','ORT01','ORT02','PAFKT','PARVW','PARZA','PERNR','PFACH','PORCIMP','PPAGO','PRDHA','PSTL2','PSTLZ','PSTYV','Proveedor de registro SSIS para archivos de texto','REGIO','RTEXT','RutaOrigen','SAKNR','SORTL','SPAAU','SPAKO','SPAKU','SPART','SPRAS','STCD1','STLKN','STLNR','STPO','STRAS','Status','T001','T001LPJ','T001W','T005H','T005T','T005U','T042Z','T151T','T188T','T691T','TATYP','TATYP1','TATYP2','TAXK1','TAXKD','TAXKD1','TAXKD2','TAXM1','TCURT','TELBX','TELF1','TELF2','TELFX','TEXCA','TEXT1','TIPOMV','TITLE','TITLE_MEDI','TPAER','TPFKT','TRUNCATE ERP_auxiliar CONFIG','TRUNCATE ERP_auxiliar FARTER','TRUNCATE ERP_auxiliar FATRDS','TRUNCATE ERP_auxiliar FATRIB','TRUNCATE ERP_auxiliar FATRIB 1','TSABT','TSAD3T','TSKDT','TSPA','TVAGT','TVAKT','TVAPT','TVAUT','TVKO','TVKOS','TVKOV','TVKWZ','TVSBT','TVTA','TVTW','TVZBT','TXLINE','TXTALINE','TZONE','VALID','VALIDO','VBELN','VKORG','VOLUM','VSBED','VTEXT','VTWEG','WAERS','WERKS','ZANYRT','ZATRIB','ZBQ0','ZBQ1','ZBQ2','ZBQ3','ZBQ4','ZBQ5','ZCEMPLE','ZCGASOL','ZCODGES','ZDETALLE','ZDIASHAB','ZFECFIN','ZFECINI','ZLSCH','ZNEMPLE','ZNGESTI','ZNUMORD','ZONE1','ZRUTAV','ZSDTR','ZTERM','ZTPCOND','ZTXTCON','ZVISITA','linea','package-diagram')
*/
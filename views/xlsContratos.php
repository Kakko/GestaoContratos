
<?php
//Configurações header para forçar o download
header ("Content-Encoding: UTF-8");
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexce; charset=UTF-8");
header ("Content-Disposition: attachment; filename=\"relatorios_contratos.xls\"" );
header ("Content-Description: PHP Generated Data" );
echo "\xEF\xBB\xBF"; // UTF-8 BOM

echo $relatorio;
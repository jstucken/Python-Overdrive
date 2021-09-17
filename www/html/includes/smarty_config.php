<?php

define('SMARTY_DIR', DOCUMENT_ROOT.'smarty/libs/');	// note trailing slash
require SMARTY_DIR.'Smarty.class.php';

// how to clear smarty cache
// https://www.smarty.net/docs/en/caching.tpl

//$smarty = new Smarty;
$smarty = new SmartyBC;	// allows {php} tags in smarty templates

$smarty->setCaching(Smarty::CACHING_OFF);

//$smarty->force_compile = true;      // degrades performance
//$smarty->debugging = true;
//$smarty->caching = false;
//$smarty->cache_lifetime = 120;
$smarty->setCacheDir(DOCUMENT_ROOT.'smarty/cache/');


// set template dir
$smarty->setTemplateDir(DOCUMENT_ROOT.'templates');
$smarty->setCompileDir(DOCUMENT_ROOT.'templates_c');

?>
<?php
require_once ('includes/site_config.php');
require_once ('includes/smarty_config.php');
require_once ('includes/header.php');

// the parent id of teacher only related docs
$teacher_parent_doc_id = 1;

//dbug($_SESSION,'$_SESSION');

// if logged in as teacher, get teacher related doc menus
if (!empty($_SESSION['user']['admin'])) {
    
    $teacher_sql = "SELECT * FROM docs WHERE parent_doc_id='$teacher_parent_doc_id' ORDER BY doc_id ASC";

    $teacher_docs = $db->getRows($teacher_sql);
    if (empty($teacher_docs)) {
        trigger_error('ERROR - Could not fetch teacher documentation from DB', E_USER_ERROR);
    }
}

//dbug($teacher_docs,'teacher_docs','green');

// get all students docs
$student_sql = "SELECT * FROM docs WHERE parent_doc_id='2' ORDER BY doc_id ASC";
$student_docs = $db->getRows($student_sql);
if (empty($student_docs)) {
    trigger_error('ERROR - Could not fetch student documentation from DB', E_USER_ERROR);
}
//dbug($student_docs,'$student_docs');

// get all the overdrive class docs
$overdrive_sql = "SELECT * FROM docs WHERE parent_doc_id='3' ORDER BY name ASC";
$overdrive_docs = $db->getRows($overdrive_sql);
if (empty($overdrive_docs)) {
    trigger_error('ERROR - Could not fetch overdrive documentation from DB', E_USER_ERROR);
}
//dbug($overdrive_docs,'overdrive_docs','blue');

////////////////////////////////////////////////////////////////////////////
// If user has browsed to a particular doc page, fetch its content from DB
$doc_id = $_GET['doc_id'];

if (!empty($doc_id)) {
    
    // sanitise doc_id
    $doc_id = db::makeDBSafe($doc_id);
    
    $doc_sql = "SELECT * FROM docs WHERE doc_id='$doc_id'";
    $doc = $db->getRow($doc_sql);
    
    if (empty($doc)) {
        trigger_error("ERROR - Could not fetch overdrive documentation from DB for doc_id: $doc_id", E_USER_ERROR);
    }
}

// assign vars to smarty
$smarty->assign('page', 'docs');
$smarty->assign('doc_id', $doc_id);

// if logged in as teacher
if (!empty($_SESSION['user']['admin'])) {
    $smarty->assign('teacher_docs', $teacher_docs);
}

$smarty->assign('student_docs', $student_docs);
$smarty->assign('overdrive_docs', $overdrive_docs);

$smarty->assign('doc', $doc);

$smarty->assign('template', getPageTemplate());
$smarty->display('default.tpl');
?>
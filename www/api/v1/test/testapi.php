<?php
require_once __DIR__.'/../auth/settings.php';
include_once('../token_validator.php');

echo json_encode(array('success' => true, 'message' => 'API 접근 성공!'));

?>
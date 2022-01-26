<?php
$action = $_GET['action'] ?? '';
header('location: public/index.php?action='.$action);
exit;
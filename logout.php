<?php
session_start();
session_destroy();
// sending to homepage
header('Location: index.html');
?>
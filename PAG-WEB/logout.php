<?php
session_start();
session_unset();
session_destroy();
header("Location: ../INICIO_DE_SESION/web.html");
exit();
?>

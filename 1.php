<?php
$clave = "Admin123";
$claveHasheada = password_hash($clave, PASSWORD_DEFAULT);
echo $claveHasheada;

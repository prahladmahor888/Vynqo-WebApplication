<?php
$pass = 'Sangfy@2026#9';
$hashed = password_hash($pass, PASSWORD_BCRYPT);
echo $hashed;
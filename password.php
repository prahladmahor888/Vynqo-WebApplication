<?php
$pass = 'Sangfy@2026#9';
$pass1 = 'Admin@123';
$hashed = password_hash($pass1, PASSWORD_BCRYPT);
echo $hashed;
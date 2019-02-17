<?php
echo md5('1234567');

$pass = password_hash('1234567',PASSWORD_BCRYPT);

echo "Hash : ".$pass;

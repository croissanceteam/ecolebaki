<?php
echo md5('1234567');

$pass = password_hash('Baki12345',PASSWORD_BCRYPT);

echo "Hash : ".$pass;

<?php
require_once __DIR__ . '/includes/config.php';

if(class_exists('Swift')){
	echo 'Swift connected </ br';
} else{
	echo 'We have a problem';
}
echo 'Proc Open: ' . function_exists('proc_open') ? 'Success' : 'Failed';

echo '<pre>';
print_r(stream_get_transports());
echo '</pre>';
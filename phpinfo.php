<?php
session_start();
// Show all information, defaults to INFO_ALL
phpinfo();

var_dump($_SESSION);

// Show just the module information.
// phpinfo(8) yields identical results.
// phpinfo(INFO_MODULES);

// print_r(wincache_fcache_fileinfo());

// print_r(wincache_fcache_meminfo());

?>
--TEST--
GH-8433 (Assigning function pointers to structs in FFI leaks memory)
--SKIPIF--
<?php
if (!extension_loaded("ffi")) die("skip ffi extension not available");
?>
--FILE--
<?php

$ffi = FFI::cdef("typedef struct { int a; } bar;");
$x = $ffi->new("bar(*)(void)");
FFI::addr($x)[0] = function() use ($ffi) {
    $bar = $ffi->new("bar");
    $bar->a = 2;
    return $bar;
};
var_dump($x());

?>
--EXPECTF--
object(FFI\CData:struct <anonymous>)#%d (1) {
  ["a"]=>
  int(2)
}

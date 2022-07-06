--TEST--
get_function_or_method_name when included file is scoped
--SKIPIF--
<?php if (!extension_loaded('zend-test')) die('skip: zend-test extension required'); ?>
--FILE--
<?php

class Foo
{
    public static function bar()
    {
        return require 'get_function_or_method_name_01.inc';
    }
}

var_dump(Foo::bar());
?>
--EXPECT--
string(4) "main"

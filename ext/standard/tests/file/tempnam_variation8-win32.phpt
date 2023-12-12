--TEST--
Test tempnam() function: usage variations - various absolute and relative paths
--CREDITS--
Dave Kelsey <d_kelsey@uk.ibm.com>
--SKIPIF--
<?php
if(substr(PHP_OS, 0, 3) != "WIN")
  die("skip Only valid for Windows");
?>
--FILE--
<?php
/* Creating unique files in various dirs by passing relative paths to $dir arg */

echo "*** Testing tempnam() with absolute and relative paths ***\n";
$dir_name = __DIR__."\\tempnam_variation8";
mkdir($dir_name);
$dir_path = $dir_name."/tempnam_variation8_sub";
mkdir($dir_path);

$old_dir_path = getcwd();
chdir(__DIR__);

$dir_paths = array(
  // absolute paths
  "$dir_path\\",
  "$dir_path\\..",
  "$dir_path\\\\..\\",
  "$dir_path\\..\\..\\.\\tempnam_variation8",
  "$dir_path\\..\\\\\\tempnam_variation8_sub\\\\..\\\\..\\tempnam_variation8",
  "$dir_path\\BADDIR",


  // relative paths
  "tempname_variation8\\",
  "tempnam_variation8\\tempnam_variation8_sub",
  "tempnam_variation8\\\\tempnam_variation8_sub",
  ".\\tempnam_variation8\\..\\tempnam_variation8\\tempnam_variation8_sub",
  "BADDIR",
);

for($i = 0; $i<count($dir_paths); $i++) {
  $j = $i+1;
  echo "\n-- Iteration $j --\n";
  $file_name = tempnam($dir_paths[$i], "tempnam_variation8.tmp");

  if( file_exists($file_name) ){

    echo "File name is => ";
    print(realpath($file_name));
    echo "\n";

    echo "File permissions are => ";
    printf("%o", fileperms($file_name) );
    echo "\n";

    echo "File created in => ";
    $file_dir = dirname($file_name);
    $dir_req = $dir_paths[$i];

    if (realpath($file_dir) == realpath(sys_get_temp_dir()) || realpath($file_dir."\\") == realpath(sys_get_temp_dir())) {
       echo "temp dir\n";
    }
    else if (realpath($file_dir) == realpath($dir_req) || realpath($file_dir."\\") == realpath($dir_req)) {
       echo "directory specified\n";
    }
    else {
       echo "unknown location\n";
    }


  }
  else {
    echo "-- File is not created --";
  }

  unlink($file_name);
}

chdir($old_dir_path);
rmdir($dir_path);
rmdir($dir_name);

echo "\n*** Done ***\n";
?>
--EXPECTF--
*** Testing tempnam() with absolute and relative paths ***

-- Iteration 1 --
File name is => %s\tempnam_variation8\tempnam_variation8_sub\t%s
File permissions are => 100666
File created in => directory specified

-- Iteration 2 --
File name is => %s\tempnam_variation8\t%s
File permissions are => 100666
File created in => directory specified

-- Iteration 3 --
File name is => %s\tempnam_variation8\t%s
File permissions are => 100666
File created in => directory specified

-- Iteration 4 --
File name is => %s\tempnam_variation8\t%s
File permissions are => 100666
File created in => directory specified

-- Iteration 5 --
File name is => %s\tempnam_variation8\t%s
File permissions are => 100666
File created in => directory specified

-- Iteration 6 --

Notice: tempnam(): file created in the system's temporary directory in %stempnam_variation8-win32.php on line %d
File name is => %s\t%s
File permissions are => 100666
File created in => temp dir

-- Iteration 7 --

Notice: tempnam(): file created in the system's temporary directory in %stempnam_variation8-win32.php on line %d
File name is => %s\t%s
File permissions are => 100666
File created in => temp dir

-- Iteration 8 --
File name is => %s\tempnam_variation8\tempnam_variation8_sub\t%s
File permissions are => 100666
File created in => directory specified

-- Iteration 9 --
File name is => %s\tempnam_variation8\tempnam_variation8_sub\t%s
File permissions are => 100666
File created in => directory specified

-- Iteration 10 --
File name is => %s\tempnam_variation8\tempnam_variation8_sub\t%s
File permissions are => 100666
File created in => directory specified

-- Iteration 11 --

Notice: tempnam(): file created in the system's temporary directory in %stempnam_variation8-win32.php on line %d
File name is => %s\t%s
File permissions are => 100666
File created in => temp dir

*** Done ***

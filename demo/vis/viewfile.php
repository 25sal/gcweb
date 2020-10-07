<?php
session_start();
if(!isset($_GET["filename"]))
 echo "<html><body><h2>Select a leaf of the tree</h2></body></html>";
else
{echo "<pre>";
  readfile($_GET["filename"]);
  echo "</pre>";
}
?>

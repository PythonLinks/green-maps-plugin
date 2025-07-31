<?php
include  "replace.php";
$html = '<a href="/old-page">Home</a><a class="btn" href="/about">About</a>';
echo replace_anchor_tags($html);
?>
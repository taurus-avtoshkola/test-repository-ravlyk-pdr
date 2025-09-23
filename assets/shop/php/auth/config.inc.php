<?php
$db = mysql_connect('localhost', 'root', '');
mysql_select_db('auth');
mysql_query("SET NAMES utf8");

session_start();
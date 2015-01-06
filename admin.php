<?php

require_once 'lib/lib.php';

$parties = db()->query('SELECT * FROM parties');

echo t()->render('admin.html', array('parties' => $parties));

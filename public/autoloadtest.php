<?php
require_once __DIR__ . '/../core/bootstrap.php';
require_once __DIR__ . '/../core/autoload.php';

$model = new TestModel();
echo "<pre style='color:#7bdcb5;'>" . $model->greet() . "</pre>";

<?php

use Phpml\Classification\KNearestNeighbors;
use Phpml\Dataset\CsvDataset;

require 'vendor/autoload.php';

$minLat = 41.34343606848294;
$maxLat = 57.844750992891;
$minLng = -16.040039062500004;
$maxLng = 29.311523437500004;

$step = 0.15;
$k = 4;

$dataset = new CsvDataset(__DIR__ . '/data/air_labeled.csv', 2, false, ';');
$estimator = new KNearestNeighbors($k);
$estimator->train($dataset->getSamples(), $dataset->getTargets());

$lines = [];
for($lat=$minLat; $lat<$maxLat; $lat+=$step) {
	for($lng=$minLng; $lng<$maxLng; $lng+=$step) {
		$lines[] = sprintf('%s;%s;%s', $lat, $lng, $estimator->predict([[$lat, $lng]])[0]);
	}
}

file_put_contents(__DIR__ . '/data/airGrid3.csv', implode(PHP_EOL, $lines));

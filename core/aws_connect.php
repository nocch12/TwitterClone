<?php

require(__DIR__ . '/../vendor/autoload.php');

use Aws\S3\S3Client;
use Aws\CommandPool;
$credentials = [
    'key' => 'AKIAY4ETYZVKEYVK75UD',
    'secret' => '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',
];

$bucket_version = 'latest';
$bucket_region = 'ap-northeast-1';
$bucket_name = 't-clone-app';


$s3 = new S3Client([
    'credentials' => $credentials,
    'region'  => $bucket_region,
    'version' => $bucket_version,
]);

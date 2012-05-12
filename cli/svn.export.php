<?php

// c - config file
// p - repository
// a - current tag
// b - old tag
// o - export path

require_once 'Zend/Console/Getopt.php';
$opts = new Zend_Console_Getopt('c:p:a:b:o:');
$opts->parse();

$options = array();

if (isset($opts->p))
    $options['repo'] = $opts->getOption('p');

if (isset($opts->b))
    $options['oldTag'] = $opts->getOption('b');

if (isset($opts->a))
    $options['newTag'] = $opts->getOption('a');

if (isset($opts->o))
    $options['exportPath'] = $opts->getOption('o');


if (isset($opts->c)) {

    $file = dirname(__FILE__) . '/' . $opts->c;
    if (file_exists($file)) {
        $configFileOptions = parse_ini_file($file);
        $options = array_merge($configFileOptions, $options);
    }
}

extract($options);

exec("svn diff --summarize --xml $repo/$newTag $repo/$oldTag > svn.log.xml");

$xmlData = file_get_contents('svn.log.xml');

$xml = new SimpleXMLElement($xmlData);

$paths = $xml->paths->path;

foreach ($paths as $key => $path)
{
    $basePath = dirname($path);
    $newPath = str_replace("$repo/$newTag", $exportPath, $path);

    if (!file_exists(dirname($newPath)))
        mkdir(dirname($newPath), 777, true);

    exec("svn export --force $path $newPath");
    echo $newPath . PHP_EOL;
}

exec("chmod -R 777 $exportPath");

unlink('svn.log.xml');

echo PHP_EOL;

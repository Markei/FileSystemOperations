<?php

namespace Markei\FileSystemOperations;

use Composer\Script\Event;

class Composer
{
    public static function run(Event $event)
    {
        $composer = $event->getComposer();
        $extra = $event->getComposer()->getPackage()->getExtra();
        // test if there is config
        if (isset($extra['markei-filesystemoperations']) === false) {
            return;
        }
        // create a filesystem and reflection object
	$fs = new \Symfony\Component\Filesystem\Filesystem();
        $reflectionClass = new \ReflectionClass($fs);
        // test if single command of array, format always as an array of commands
        $first = reset($extra['markei-filesystemoperations']);
        if (is_array($first) === false) {
            $extra['markei-filesystemoperations'] = [$extra['markei-filesystemoperations']];
        }
        // loop all commands
        foreach ($extra['markei-filesystemoperations'] as $command) {
            $fullCommand = $command;
            $operation = array_shift($command);
            $parameters = $command;
            if ($reflectionClass->hasMethod($operation) === false) {
                throw new \RuntimeException('Operation "' . $operation . '" not supported, configured as: ' . json_encode($fullCommand));
            }
            $method = $reflectionClass->getMethod($operation);
            if ($method->isPublic() === false) {
                throw new \RuntimeException('Operation "' . $operation . '" not allowed, configured as: ' . json_encode($fullCommand));
            }
            $method->invokeArgs($fs, $parameters);
        }
    }
}
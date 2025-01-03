<?php

declare(strict_types=1);

namespace AdventOfCode\Traits;

trait ReflectionTesterTrait
{
    static private function assertClassConstantSame($expected, string $className, string $contName)
    {
        $const = new \ReflectionClassConstant($className, $contName);
        static::assertSame($expected, $const->getValue());
    }

    static public function assertClassVarSame($expected, object $class, string $varName)
    {
        $var = new \ReflectionProperty($class, $varName);
        static::assertSame($expected, $var->getValue($class));
    }
}

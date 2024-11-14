<?php

namespace App\Traits;

use ReflectionEnum;

trait HasOptionsEnum
{
    public static function options(): array
    {
        $enumReflection = new ReflectionEnum(static::class);
        $cases = $enumReflection->getCases();

        $options = [];
        foreach ($cases as $case) {
            $atributos = collect($case->getAttributes())
                ->mapWithKeys(fn($attr) => [$attr->getName() => $attr->getArguments()[0]])
                ->toArray();

            $options[] = [
                ...$atributos,
                'name' => $case->getName(),
                'value' => $case->getValue()->value,
            ];
        }

        return $options;
    }
}

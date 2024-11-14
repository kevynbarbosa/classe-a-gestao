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
            $attributes = collect($case->getAttributes())
                ->mapWithKeys(function ($attribute) {
                    $name = strtolower(
                        basename(str_replace(['\\', 'Enum'], ['/', ''], $attribute->getName()))
                    );
                    $argument = $attribute->getArguments()[0] ?? null;

                    return [$name => $argument];
                })
                ->toArray();

            $options[] = [
                ...$attributes,
                'name' => $case->getName(),
                'value' => $case->getValue()->value,
            ];
        }

        return $options;
    }
}

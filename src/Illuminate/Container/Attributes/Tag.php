<?php

declare(strict_types=1);

namespace Illuminate\Container\Attributes;

use Attribute;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class Tag implements ContextualAttribute
{
    /**
     * @param class-string|null $wrapInto
     */
    public function __construct(
        public string $tag,
        public ?string $wrapInto = null
    ) {
    }

    /**
     * Resolve the tag.
     *
     * @param  self  $attribute
     * @param  \Illuminate\Contracts\Container\Container  $container
     * @return mixed
     */
    public static function resolve(self $attribute, Container $container)
    {
        $tagged = $container->tagged($attribute->tag);

        if ($attribute->wrapInto) {
            return new $attribute->wrapInto($tagged);
        }

        return $tagged;
    }
}

<?php

namespace Spatie\BladeX;

use Spatie\BladeX\Exceptions\InvalidComponent;

class BladeX
{
    /** @var array */
    public $registeredComponents = [];

    public function component(string $componentName, string $classOrView)
    {
        $component = $this->getComponent($classOrView);

        if (! $component) {
            throw InvalidComponent::notFound($componentName, $classOrView);
        }

        $this->registeredComponents[$componentName] = $component;
    }

    public function components()
    {

    }

    protected function getComponent(string $classOrView): ?object
    {
        if (class_exists($classOrView)) {
            return app($classOrView);
        }

        if (view()->exists($classOrView)) {
            return new BladeViewComponent(view($classOrView));
        }

        return null;
    }
}

<?php
namespace App\Core\Container;

class ServiceContainer {
    private $services = [];
    private $instances = [];

    public function bind($abstract, $concrete = null) {
        if ($concrete === null) {
            $concrete = $abstract;
        }
        $this->services[$abstract] = $concrete;
    }

    public function singleton($abstract, $concrete = null) {
        $this->bind($abstract, $concrete);
        $this->instances[$abstract] = null;
    }

    public function resolve($abstract) {
        if (isset($this->instances[$abstract])) {
            if ($this->instances[$abstract] === null) {
                $this->instances[$abstract] = $this->build($abstract);
            }
            return $this->instances[$abstract];
        }

        return $this->build($abstract);
    }

    private function build($abstract) {
        $concrete = $this->services[$abstract] ?? $abstract;

        if ($concrete instanceof \Closure) {
            return $concrete($this);
        }

        if (is_string($concrete)) {
            return $this->resolveClass($concrete);
        }

        return $concrete;
    }

    private function resolveClass($class) {
        $reflector = new \ReflectionClass($class);

        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$class} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $class;
        }

        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();
            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->resolve($type->getName());
            }
        }

        return $reflector->newInstanceArgs($dependencies);
    }

    public function get($abstract) {
        return $this->resolve($abstract);
    }
}

<?php

namespace App;

use Closure;
use ReflectionClass;
use ReflectionParameter;
use App\Traveller;

// 容器类 容器类实例或者提供实例的回调函数
class Container
{
    //
    protected $bindings = [];

    //绑定接口和生成应用实例的回调函数
    public function bind($abstract, $concrete = null, $shared = false)
    {
        if (!$concrete instanceof Closure) {
            //如果提供的参数不是回调函数，产生默认的回调函数
            $concrete = $this->getClosure($abstract, $concrete);
        }
        $this->bindings[$abstract] = compact('concrete', 'shared');
    }

    //默认生成实例的回调函数
    protected function getClosure($abstract, $concrete)
    {
        //生成实例的回调函数 $c 一般为容器的Ioc 容器对象 在调用回调生成实例时候提供
        return function ($c) use ($abstract, $concrete) {
            $method = ($abstract == $concrete) ? 'build' : 'make';
            return $c->$method($concrete);
        };
    }

    //生成实例对象 首先要解决接口和实例类之间的依赖关系
    public function make($abstract)
    {
        $concrete = $this->getConcrete($abstract);
        if ($this->isBuildable($concrete, $abstract)) {
            $object = $this->build($concrete);
        } else {
            $object = $this->make($concrete);
        }
        return $object;
    }

    protected function isBuildable($concrete, $abstract)
    {
        return $concrete === $abstract || $concrete instanceof Closure;
    }

    protected function getConcrete($abstract)
    {
        if (!isset($this->bindings[$abstract])) {
            return $abstract;
        }
        return $this->bindings[$abstract]['concrete'];
    }

    public function build($concrete)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }
        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            echo $message = "Target [$concrete] is not test";
        }
        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }
        $dependencies = $constructor->getParameters();
        $instances = $this->getDependencies($dependencies);
        return $reflector->newInstanceArgs($instances);

    }

    protected function getDependencies($parameters)
    {
        $dependency = [];
        foreach ($parameters as $parameter) {
            $dependencies = $parameter->getClass();
            if (is_null($dependency)) {
                $dependencies[] = null;
            } else {
                $dependencies[] = $this->resolveClass($parameter);
            }
        }
        return (array)$dependencies;
    }

    protected function resolveClass(ReflectionParameter $parameter)
    {
        return $this->make($parameter->getClass()->name);
    }
}
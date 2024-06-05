<?php

namespace ScoRugby\Core\Utility;

/**
 * Description of CastableObject
 *
 * @author Antoine BOUET
 */
class CastableObject {

    public static function cast(\stdClass $source, string $class): object {
        $srcReflection = new \ReflectionObject($source);
        $destReflection = new \ReflectionClass($class);
        $destination = new $class();
        foreach ($srcReflection->getProperties() as $property) {
            $name = $property->getName();
            $getter = strtolower('get' . $name);
            $setter = strtolower('set' . $name);
            // get value
            if ($srcReflection->hasMethod($getter)) {
                $method = new \ReflectionMethod($srcReflection, $getter);
                $val = $method->invoke($getter);
            } elseif ($srcReflection->hasProperty($name)) {
                $proprtyObj = $srcReflection->getProperty($name);
                $val = $proprtyObj->getValue();
            }
            // set value
            if ($destReflection->hasMethod($setter)) {
                $result = $destReflection->getMethod($setter)->invoke($destination, [$val]);
            } elseif ($destReflection->hasProperty($name)) {
                $destReflection->getProperty($name)->setValue($destination, $val);
            }
        }
        return $destination;
    }
}

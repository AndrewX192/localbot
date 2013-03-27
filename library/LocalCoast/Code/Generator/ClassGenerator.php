<?php
/**
 * LocalCoast PCL (PHP Common Library)
 *
 * @category    LocalCoast
 * @package     LocalCoast_Code
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */

/**
 * @namespace
 */
namespace LocalCoast\Code\Generator;

/**
 * @uses       \Zend\Code\Reflection\ClassReflection
 * @uses       \Zend\Code\Generator\ClassGenerator
 * @uses       \Zend\Code\Generator\MethodGenerator
 * @category   LocalCoast
 * @package    LocalCoast_CodeGenerator
 */
use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Generator\ClassGenerator as ZendClassGenerator;
use Zend\Code\Generator\MethodGenerator as MethodGenerator;

class ClassGenerator extends ZendClassGenerator
{
    /**
     * fromReflection() - build a Code Generation Php Object from a Class Reflection
     *
     * @param   ReflectionClass $classReflection
     *
     * @return  ClassGenerator
     */
    public static function fromReflection(ClassReflection $classReflection)
    {
        $cg = parent::fromReflection($classReflection);

        $methods = array();

        foreach ($classReflection->getMethods() as $reflectionMethod) {
            if (
                $reflectionMethod->getDeclaringClass()->getName()
                    == $cg->getNamespaceName() . '\\' . $cg->getName()
            ) {
                $methods[] = MethodGenerator::fromReflection($reflectionMethod);
            }
        }

        $cg->setMethods($methods);

        $interfaces = array();

        foreach ($classReflection->getInterfaceNames() as $interface) {
            $interface =  '\\' . $interface;
            $interfaces[] = $interface;
        }

        $cg->setImplementedInterfaces($interfaces);

        return $cg;
    }
}

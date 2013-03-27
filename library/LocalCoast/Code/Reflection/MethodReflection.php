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
namespace LocalCoast\Code\Reflection;

/**
 * @uses       \Zend\Code\Reflection\ClassReflection
 * @uses       \Zend\Code\Generator\ClassGenerator
 * @uses       \Zend\Code\Generator\MethodGenerator
 * @category   LocalCoast
 * @package    LocalCoast_CodeMethodGenerator
 */
use Zend\Code\Reflection\MethodReflection as ZendMethodReflection;

class MethodReflection extends ZendMethodReflection
{
    /**
     * Get method body
     *
     * @return string
     */
    public function getBody()
    {
        $lines = array_slice(
            file($this->getDeclaringClass()->getFileName(), FILE_IGNORE_NEW_LINES),
            $this->getStartLine(),
            ($this->getEndLine() - $this->getStartLine()),
            true
        );

        $firstLine = array_shift($lines);

        if (trim($firstLine) !== '{') {
            array_unshift($lines, $firstLine);
        }

        $lastLine = array_pop($lines);

        if (trim($lastLine) !== '}') {
            array_push($lines, $lastLine);
        }

        // just in case we had code on the bracket lines
        return trim(implode("\n", $lines));
    }
}

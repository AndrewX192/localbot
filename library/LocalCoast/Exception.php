<?php
/**
 * LocalCoast Library
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @license     
 */

namespace LocalCoast;

/**
 * The LocalCoast Exception
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */
class Exception extends \Exception
{
    /**
     * Throw an error as an exception.
     *
     * @param   int     $errno
     * @param   string  $errstr
     * @param   string  $errfile
     * @param   int     $errline
     * @param   mixed   $errcontext
     *
     * @throws  LocalCoast_Exception
     *
     * @return  bool
     */
    static public function throwError($errno, $errstr, $errfile = '', $errline = 0, array $errcontext = array()) {
        if (0 != error_reporting()) {
            $e          = new self($errstr, 0);
            $e->file    = $errfile;
            $e->line    = $errline;

            throw $e;
        }
    }
}
<?php
/**
 * LocalCoast Common Library
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license      
 */

/**
 * LocalCoast Reloadable interface.
 *
 * @category    LocalCoast
 * @package     LocalCoast
 * @author      Andrew Sorensen <andrew@localcoast.net>
 * @license     
 */
namespace LocalCoast;

interface Reloadable {

    public function deregister();

    public function load();

    public function onDeregister();

    public function onLoad();

    public function _deregisterEventHandlers();

    public function _registerEventHandlers();
}
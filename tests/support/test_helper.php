<?php
/**
 * A base controller for CodeIgniter with view autoloading, layout support,
 * model, helper, and library loading, asides/partials and per-controller 404
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-controller
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

require_once 'core/MY_Controller.php';
require_once 'tests/support/test_controllers.php';

/**
 * test_helper.php is the bootstrap file for our tests - it loads up an
 * appropriate faux-CodeIgniter environment for our tests to run in.
 */

define('APPPATH', dirname(__FILE__));

class CI_Controller
{
    public function __construct()
    {
        if (!isset($this->load))
        {
            $this->load = new CI_Loader();
        }
    }
}

/**
 * Here, we fakify various core CodeIgniter classes. These are either here
 * so it runs through (ignoring implementation) or they'll be mocked
 */
class CI_Loader
{
    public function model($name, $assign) {}
    public function helper($name) {}
    public function library($name) {}
    public function view($file, $data = array(), $ret = FALSE) {}

    public function __call($method, $params = array()) {}
}

class CI_URI
{
    public $rsegments = array();
}

class CI_Router
{
    public $directory = '';
    public $class = '';
    public $method = '';
}

class CI_Output
{
    public function set_output($data) { }
}
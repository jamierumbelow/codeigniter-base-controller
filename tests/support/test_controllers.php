<?php
/**
 * A base controller for CodeIgniter with view autoloading, layout support,
 * model loading, asides/partials and per-controller 404
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-controller
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

/**
 * Because the main functionality of the MY_Controller is handled through
 * protected variables, a bunch of fake classes are used to ensure that things
 * are behaving the way they should do in the tests.
 */

class Users extends MY_Controller
{
    protected $models = array( 'user', 'group', 'session' );

    public function show()
    {
        $this->data['variable'] = 'passed_through_value';
    }
}

class Differently_Named_Models extends MY_Controller
{
    protected $models = array( 'user', 'group', 'session' );
    protected $model_string = 'm_%';
}

class Asides extends MY_Controller
{
    protected $asides = array( 'sidebar' => 'asides/sidebar', 'navigation' => 'asides/navigation' );

    public function index()
    {
        $this->data['variable'] = 'passed_through_value';
    }
}

class Overrided_View_Layout extends MY_Controller
{
    protected $view = 'random/view';
    protected $layout = 'layouts/another_random_one';

    public function index() { }
}

class No_Layout extends MY_Controller
{
    protected $layout = FALSE;

    public function index() { }
}
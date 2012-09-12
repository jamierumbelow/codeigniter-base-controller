<?php
/**
 * A base controller for CodeIgniter with view autoloading, layout support,
 * model loading, helper loading, asides/partials and per-controller 404
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-controller
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

require_once 'tests/support/test_helper.php';

class MY_Controller_tests extends PHPUnit_Framework_TestCase
{
    public $controller;

    /* --------------------------------------------------------------
     * VIEW AUTOLOADING
     * ------------------------------------------------------------ */

    public function test_autoloads_view()
    {
        $this->controller = new Users();
        $this->controller->load = $this->getMock('CI_Loader');
        $this->controller->uri = new CI_URI();

        $this->controller->router = new CI_Router();
        $this->controller->router->class = 'users';
        $this->controller->router->method = 'show';

        $this->controller->load->expects($this->at(0))
                               ->method('view')
                               ->with($this->equalTo('users/show'), $this->equalTo(array( 'variable' => 'passed_through_value' )), $this->equalTo(TRUE))
                               ->will($this->returnValue('View Data'));
        $this->controller->load->expects($this->at(1))
                               ->method('view')
                               ->with($this->equalTo('layouts/application'), $this->equalTo(array( 'variable' => 'passed_through_value', 'yield' => 'View Data' )));

        $this->controller->_remap('show', array());
    }

    public function test_loads_asides()
    {
        $this->controller = new Asides();
        $this->controller->load = $this->getMock('CI_Loader');
        $this->controller->uri = new CI_URI();

        $this->controller->router = new CI_Router();
        $this->controller->router->class = 'asides';
        $this->controller->router->method = 'index';

        $this->controller->load->expects($this->at(0))
                               ->method('view')
                               ->will($this->returnValue('View Data'));

        $this->controller->load->expects($this->at(1))
                               ->method('view')
                               ->with($this->equalTo('asides/sidebar'), $this->equalTo(array( 'variable' => 'passed_through_value' )), $this->equalTo(TRUE))
                               ->will($this->returnValue('Sidebar Data'));
        $this->controller->load->expects($this->at(2))
                               ->method('view')
                               ->with($this->equalTo('asides/navigation'), $this->equalTo(array( 'variable' => 'passed_through_value' )), $this->equalTo(TRUE))
                               ->will($this->returnValue('Navigation Data'));

        $this->controller->load->expects($this->at(3))
                               ->method('view')
                               ->with($this->equalTo('layouts/application'), $this->equalTo(array( 'variable' => 'passed_through_value', 'yield' => 'View Data', 'yield_sidebar' => 'Sidebar Data', 'yield_navigation' => 'Navigation Data' )));

        $this->controller->_remap('index', array());
    }

    public function test_view_and_layout_are_overridable()
    {
        $this->controller = new Overrided_View_Layout();
        $this->controller->load = $this->getMock('CI_Loader');
        $this->controller->uri = new CI_URI();

        $this->controller->router = new CI_Router();
        $this->controller->router->class = 'users';
        $this->controller->router->method = 'show';

        $this->controller->load->expects($this->at(0))
                               ->method('view')
                               ->with($this->equalTo('random/view'));
        $this->controller->load->expects($this->at(1))
                               ->method('view')
                               ->with($this->equalTo('layouts/another_random_one'));

        $this->controller->_remap('index', array());
    }

    public function test_layout_false_view_is_outputted()
    {
        $this->controller = new No_Layout();
        $this->controller->load = $this->getMock('CI_Loader');
        $this->controller->uri = new CI_URI();
        $this->controller->router = new CI_Router();
        $this->controller->output = $this->getMock('CI_Output');

        $this->controller->load->expects($this->at(0))
                               ->method('view')
                               ->will($this->returnValue('VIEW DATA HERE'));
        $this->controller->output->expects($this->at(0))
                                 ->method('set_output')
                                 ->with($this->equalTo('VIEW DATA HERE'));

        $this->controller->_remap('index', array());
    }

    /* --------------------------------------------------------------
     * MODEL LOADING
     * ------------------------------------------------------------ */

    public function test_constructor_loads_models()
    {
        $this->controller = new Users();
        $this->controller->load = $this->getMock('CI_Loader');

        $this->controller->load->expects($this->at(0))
                               ->method('model')
                               ->with($this->equalTo('user_model'), $this->equalTo('user'));
        $this->controller->load->expects($this->at(1))
                               ->method('model')
                               ->with($this->equalTo('group_model'), $this->equalTo('group'));
        $this->controller->load->expects($this->at(2))
                               ->method('model')
                               ->with($this->equalTo('session_model'), $this->equalTo('session'));

        $this->controller->__construct();
    }

    public function test_constructor_loads_differently_named_models()
    {
        $this->controller = new Differently_Named_Models();
        $this->controller->load = $this->getMock('CI_Loader');

        $this->controller->load->expects($this->at(0))
                               ->method('model')
                               ->with($this->equalTo('m_user'), $this->equalTo('user'));
        $this->controller->load->expects($this->at(1))
                               ->method('model')
                               ->with($this->equalTo('m_group'), $this->equalTo('group'));
        $this->controller->load->expects($this->at(2))
                               ->method('model')
                               ->with($this->equalTo('m_session'), $this->equalTo('session'));

        $this->controller->__construct();
    }

    /* --------------------------------------------------------------
     * HELPER LOADING
     * ------------------------------------------------------------ */

    public function test_constructor_loads_helpers()
    {
        $this->controller = new Helpers();
        $this->controller->load = $this->getMock('CI_Loader');

        $this->controller->load->expects($this->at(0))
                               ->method('helper')
                               ->with($this->equalTo('cookie'));
        $this->controller->load->expects($this->at(1))
                               ->method('helper')
                               ->with($this->equalTo('file'));
        $this->controller->load->expects($this->at(2))
                               ->method('helper')
                               ->with($this->equalTo('xml'));

        $this->controller->__construct();
    }
}
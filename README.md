# codeigniter-base-controller

codeigniter-base-controller is an extended `CI_Controller` class to use in your CodeIgniter applications. Any controllers that inherit from `MY_Controller` get intelligent view autoloading, layout support and asides/partials. It's strongly driven by the ideals of convention over configuration, favouring simplicity and consistency over configuration and complexity.

## Synopsis

    class Users extends MY_Controller
    {
        protected $models = array( 'user', 'group' );

        public function index()
        {
            $this->data['users'] = $this->user->get_all();
        }

        public function show($id)
        {
            if ($this->input->is_ajax_request())
            {
                $this->layout = FALSE;
            }

            $this->data['user'] = $this->user->get($id);
            $this->data['groups'] = $this->group->get_all();
        }
    }

## Usage

Drag the **MY\_Controller.php** file into your _application/core_ folder. CodeIgniter will load and initialise this class automatically for you. Extend your controller classes from `MY_Controller` and the functionality will be available automatically.

## Views and Layouts

Views will be loaded automatically based on the current controller and action name. Any variables set in `$this->data` will be passed through to the view and the layout. By default, the class will look for the view in _application/views/controller/action.php_.

In order to prevent the view being automatically rendered, set `$this->view` to `FALSE`.

    $this->view = FALSE;

Or, to load a different view than the automatically guessed view:

    $this->view = 'some_path/some_view.php';

Views will be loaded into a layout. The class will look for an _application/views/layouts/controller.php_ layout file; if it can't be found it will fall back to an _application/views/layouts/application.php_ file, which is the defacto, application-wide layout.

In order to specify where in your layout you'd like to output the view, the rendered view will be stored in a `$yield` variable:

    <h1>Header</h1>

    <div id="page">
        <?= $yield ?>
    </div>

    <p>Footer</p>

If you wish to disable the layout entirely and only display the view - a technique especially useful for AJAX requests - you can set `$this->layout` to `FALSE`.

    $this->layout = FALSE;

Like with `$this->view`, `$this->layout` can also be used to specify an unconventional layout file:

    $this->layout = 'layouts/mobile.php';

Any variables set in `$this->data` will be passed through to both the view and the layout files, as well as any asides.
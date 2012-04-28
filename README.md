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

## Asides

Asides are a great way to insert variable content into your layouts that might need to change on an action by action basis. This is especially helpful when you want to load sidebars or render separate forms of navigation.

Asides are arbitrary views loaded into variables. They can be set using the `$this->asides` variable:

    protected $asides = array( 'sidebar' => 'users/_sidebar' );

They're then exposed as `$yield_` variables in the layout:

    <div id="sidebar">
        <?= $yield_sidebar ?>
    </div>

Any variables in `$this->data` will be passed through to the sidebar.

## Model Loading

You can specify a list of models to load with the `$this->models` variable:

    protected $models = array( 'user', 'photograph', 'post' );

The model name is based on the `$this->model_string` variable. This allows you to name your models however you like. By default, the model string is:

    protected $model_string = '%_model';

The percent symbol (`%`) will be replaced with the model name in the `$this->models` array. It will then be loaded into the CI object under the declared name.

    protected $models = array( 'user' );

    public function index()
    {
        // $this->load->model('user_model', 'user');
        $this->user->get(1);
    }

If, for example, you name your models `model_user`, you can specify the model string:

    protected $models = array( 'user' );
    protected $model_string = 'model_%';

    public function index()
    {
        // $this->load->model('model_user', 'user');
        $this->user->get(1);
    }

## Per-controller 404 override

Before CodeIgniter throws a standard 404, `MY_Controller` will look for a `_404` method on the controller. This allows you to customise the output of the 404 page on a controller-by-controller basis.

## Changelog

**Version 1.3.0 - IN DEVELOPMENT**
* Vastly improved documentation

**Version 1.0.0 - 1.2.0**
* Initial Release
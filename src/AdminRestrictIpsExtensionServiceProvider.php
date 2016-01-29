<?php namespace Markbratanov\AdminRestrictIpsExtension;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

class AdminRestrictIpsExtensionServiceProvider extends AddonServiceProvider
{

    protected $plugins = [];

    protected $routes = [];

    protected $middleware = [
        'Markbratanov\AdminRestrictIpsExtension\Http\Middleware\AdminCheckWhitelist'
    ];

    protected $listeners = [];

    protected $aliases = [];

    protected $bindings = [];

    protected $providers = [];

    protected $singletons = [];

    protected $overrides = [];

    protected $mobile = [];

    public function register()
    {
    }

    public function map()
    {
    }

}

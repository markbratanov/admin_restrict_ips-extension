<?php namespace Markbratanov\AdminRestrictIpsExtension\Http\Middleware;

use Anomaly\UsersModule\User\UserSecurity;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthenticateRequest
 *
 * This class replaces the Laravel version in app/
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UsersModule\Http\Middleware
 */
class AdminCheckWhitelist
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $guard;

    /**
     * The security utility.
     *
     * @var UserSecurity
     */
    protected $security;

    /**
     * The response factory.
     *
     * @var ResponseFactory
     */
    protected $response;

    /**
     * The redirector utility.
     *
     * @var Redirector
     */
    protected $redirect;



    /**
     * Create a new AuthenticateRequest instance.
     *
     * @param Guard           $guard
     * @param Redirector      $redirect
     * @param ResponseFactory $response
     * @param UserSecurity    $security
     */
    public function __construct(
        Guard $guard,
        Redirector $redirect,
        ResponseFactory $response,
        UserSecurity $security
    ) {
        $this->guard    = $guard;
        $this->redirect = $redirect;
        $this->response = $response;
        $this->security = $security;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin/*') && !$this->ipIsWhiteListed($request))  {
            return $this->response->make('Unauthorized.', 401);
        }

        $response = $this->security->check($this->guard->user());

        if ($response instanceof Response) {
            return $response;
        }

        return $next($request);
    }



    private function ipIsWhiteListed(Request $request)
    {
        $ip = $request->getClientIp();

        $allowed = array(
            '127.0.0.1',
            'sennit.dev',
            '192.168.100.1'
        );

        return in_array($ip, $allowed);
    }

}
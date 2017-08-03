<?php declare(strict_types=1);

namespace WPouseele\OAuth2\Client\Laravel;

use WPouseele\OAuth2\Client\Provider\AzureCosts;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider;

class AzureCostsServiceProvider extends ServiceProvider
{
    protected $defer = false;
    
    public function boot()
    {
        $source = realpath($raw = __DIR__.'/config/oauth2-azurecosts.php') ?: $raw;
        
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('oauth2-azurecosts.php')], 'config');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('oauth2-azurecosts');
        }
        $this->mergeConfigFrom($source, 'oauth2-azurecosts');

        $this->app->bind(AzureCosts::class, function() use ($config) {
            $azurecosts = new AzureCosts([
                'clientId' => $config->get('oauth2-azurecosts.clientId'),
                'clientSecret' => $config->get('oauth2-azurecosts.clientSecret'),
                'redirectUri' => $config->get('oauth2-azurecosts.redirectUri')
            ]);
            return $azurecosts;
        });
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
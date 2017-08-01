<?php namespace WPouseele\OAuth2\Client\FrameworkIntegration\Laravel;

use WPouseele\OAuth2\Client\Provider\AzureCosts;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider;

class AzureCostsServiceProvider extends ServiceProvider
{
    protected $defer = false;
    
    public function boot(Repository $config)
    {
        $this->publishes([
            __DIR__."/config/config.php" => config_path('oauth2-azurecosts.php')
        ], 'config');

        $this->mergeConfigFrom(__DIR__."/config/config.php", 'oauth2-azurecosts');

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
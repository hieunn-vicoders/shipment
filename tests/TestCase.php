<?php

namespace VCComponent\Laravel\Shipment\Test;

use Cviebrock\EloquentSluggable\ServiceProvider;
use Dingo\Api\Provider\LaravelServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use VCComponent\Laravel\Shipment\Providers\ShipmentServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelServiceProvider::class,
            ServiceProvider::class,
            ShipmentServiceProvider::class
        ];
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withFactories(__DIR__ . '/../tests/Stubs/Factory');
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:TEQ1o2POo+3dUuWXamjwGSBx/fsso+viCCg9iFaXNUA=');
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('shipment.namespace', 'shipment-management');
        $app['config']->set('shipment.models', [
            'shipment' => \VCComponent\Laravel\Shipment\Test\Stubs\Entities\Shipment::class,
            'shipment_status' => \VCComponent\Laravel\Shipment\Entities\ShipmentStatus::class,
            'shipment_status_history' => \VCComponent\Laravel\Shipment\Entities\ShipmentStatusHistory::class,
        ]);
        $app['config']->set('shipment.transformers', [
            'meta' => \VCComponent\Laravel\Shipment\Transformers\ShipmentTransformer::class,
            'shipment_status' => \VCComponent\Laravel\Shipment\Transformers\ShipmentStatusTransformer::class,
            'shipment_status_history' => \VCComponent\Laravel\Shipment\Transformers\ShipmentStatusHistoryTransformer::class,
        ]);
        $app['config']->set('shipment.auth_middleware', [
            'admin' => [
                [
                    'middleware' => '',
                    'except' => [],
                ],
            ],
            'frontend' => [
                'middleware' => '',
            ],
        ]);
        $app['config']->set('api', [
            'standardsTree' => 'x',
            'subtype' => '',
            'version' => 'v1',
            'prefix' => 'api',
            'domain' => null,
            'name' => null,
            'conditionalRequest' => true,
            'strict' => false,
            'debug' => true,
            'errorFormat' => [
                'message' => ':message',
                'errors' => ':errors',
                'code' => ':code',
                'status_code' => ':status_code',
                'debug' => ':debug',
            ],
            'middleware' => [
            ],
            'auth' => [
            ],
            'throttling' => [
            ],
            'transformer' => \Dingo\Api\Transformer\Adapter\Fractal::class,
            'defaultFormat' => 'json',
            'formats' => [
                'json' => \Dingo\Api\Http\Response\Format\Json::class,
            ],
            'formatsOptions' => [
                'json' => [
                    'pretty_print' => false,
                    'indent_style' => 'space',
                    'indent_size' => 2,
                ],
            ],
        ]);
        $app['config']->set('jwt.secret', '5jMwJkcDTUKlzcxEpdBRIbNIeJt1q5kmKWxa0QA2vlUEG6DRlxcgD7uErg51kbBl');

    }
    public function assertExits($response, $error_message)
    {
        $response->assertStatus(400);
        $response->assertJson([
            'message' => $error_message,
        ]);
    }
    public function assertValidator($response, $field, $error_message)
    {
        $response->assertStatus(422);
        $response->assertJson([
            'message' => "The given data was invalid.",
            "errors" => [
                $field => [
                    $error_message,
                ],
            ],
        ]);
    }
    public function assertRequired($response, $error_message)
    {
        $response->assertStatus(500);
        $response->assertJsonFragment([
            'message' => $error_message,
        ]);
    }
    protected function loginToken()
    {
        $dataLogin = ['username' => 'admin', 'password' => '123456789', 'email' => 'admin@test.com'];
        $user = factory(User::class)->make($dataLogin);
        $user->save();

        $admin_role = factory(Role::class)->create([
            'name' => 'admin',
            'slug' => 'admin'
        ]); 

        $user->attachRole($admin_role);
        $login = $this->json('POST', 'api/user-management/login', $dataLogin);

        $token = $login->Json()['token'];
        return $token;

    }
}

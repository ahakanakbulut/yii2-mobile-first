<?php
/**
 * @link https://github.com/vuongxuongminh/yii2-mobile-first
 * @copyright Copyright (c) 2019 Vuong Xuong Minh
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace vxm\test\unit\mobileFirst;

use vxm\mobileFirst\AdaptiveFilter;
use vxm\mobileFirst\ViewRenderBehavior;
use Yii;

use yii\helpers\ArrayHelper;

use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class TestCase
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class TestCase extends BaseTestCase
{


    public function setUp(): void
    {
        parent::setUp();

        $this->mockApplication();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->destroyApplication();
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication($config = [], $appClass = '\yii\web\Application'): void
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'test',
            'basePath' => __DIR__,
            'controllerMap' => [
                'test' => TestController::class
            ],
            'vendorPath' => dirname(__DIR__) . '/vendor',
            'components' => [
                'request' => [
                    'cookieValidationKey' => 'wefJDF8sfdsfSDefwqdxj9oq',
                    'scriptFile' => __DIR__ . '/index.php',
                    'scriptUrl' => '/index.php',
                    'url' => 'http://abc.test'
                ],
                'view' => [
                    'as mobileFirst' => [
                        'class' => ViewRenderBehavior::class,
                        'dirMap' => [
                            'mobile' => 'mobile',
                            'tablet' => 'tablet'
                        ]
                    ],
                    'renderers' => [
                        'php' => TestRenderer::class
                    ]
                ]
            ],
            'as mobileFirst' => [
                'class' => AdaptiveFilter::class,
                'redirectUrl' => 'https://abc.com'
            ]
        ], $config));
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication(): void
    {
        $_SERVER['HTTP_USER_AGENT'] = null;
        $_SERVER['REQUEST_METHOD'] = 'GET';

        Yii::$app = null;
    }


}

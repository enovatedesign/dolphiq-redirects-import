<?php
/**
 * Created by PhpStorm.
 * User: leecr
 * Date: 08/01/2019
 * Time: 15:19
 */
namespace enovate\dolphiqredirectsimport;

use craft\base\Plugin;
use craft\events\RegisterUrlRulesEvent;
use craft\web\UrlManager;

use yii\base\Event;

class DolphiqRedirectsImport extends Plugin
{

    public $hasCpSettings = true;
    public $hasCpSection = true;

    public $main_uri;

    public function init()
    {
        parent::init();

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['redirects/import'] = 'dolphiqredirectsimport/dolphiq-redirects-import/import';
            }
        );
    }

}
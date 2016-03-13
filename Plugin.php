<?php namespace Uxms\Backendstyle;

use App;
use File;
use Lang;
use Event;
use Flash;
use Config;
use Backend;
use Request;
use Redirect;
use Backend\Classes\Controller;
use Backend\Models\BrandSettings;
use System\Classes\PluginBase;


class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'uxms.backendstyle::lang.app.name',
            'description' => 'uxms.backendstyle::lang.app.desc',
            'author'      => 'uXMs Devs',
            'icon'        => 'icon-object-group',
            'homepage'    => 'https://uxms.net/'
        ];
    }

    public function boot()
    {
        if (!App::runningInBackend())
            return;

        Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
            $appUrl = Config::get('app.url');

            if (Request::secure()) {
                $appUrl = preg_replace(
                    "/^http:/i",
                    "https:",
                    Config::get('app.url')
                );
            }

            $controller->addJs($appUrl.'/plugins/uxms/backendstyle/assets/changer.js');
            $controller->addCss($appUrl.'/plugins/uxms/backendstyle/assets/changer.css');
        });

        Controller::extend(function($controller) {
            $controller->addDynamicMethod('onChangeSkin', function() {
                return $this->onChangeSkin();
            });
        });
    }

    /**
     * Changes backend skin with predefined stylesheets
     * 
     * @return [type] [description]
     */
    public function onChangeSkin()
    {
        $whichSkinSelected = post('skin');
        $style = '';

        if ($whichSkinSelected <> 'default') {
            $selectedSkinfile = plugins_path()."/uxms/backendstyle/assets/stylesheets/$whichSkinSelected.css";
            $style = File::get($selectedSkinfile);
        }

        BrandSettings::set('custom_css', $style);

        Flash::success(Lang::get('uxms.backendstyle::lang.app.success'));
        return Redirect::refresh();
    }

}

<?php namespace Uxms\Backendstyle;

use App;
use File;
use Event;
use Flash;
use Backend;
use Redirect;
use Backend\Classes\Controller;
use Backend\Models\BrandSettings;
use System\Classes\PluginBase;


class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'Backend Style Changer',
            'description' => 'Changes the skin of backend with a pre-defined stylesheet',
            'author'      => 'Uxms Devs',
            'icon'        => 'icon-object-group'
        ];
    }

    public function boot()
    {
        if (!App::runningInBackend())
            return;

        Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
            $controller->addJs('../plugins/uxms/backendstyle/assets/changer.js');
            $controller->addCss('../plugins/uxms/backendstyle/assets/changer.css');
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

        Flash::success('Skin changed');
        return Redirect::refresh();
    }

}

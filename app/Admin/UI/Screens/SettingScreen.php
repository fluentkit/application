<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\Actions\SaveAction;
use FluentKit\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingScreen extends FormScreen
{
    public function __construct()
    {
        $this->addAction(
            (new SaveAction('save', 'Save Changes'))
                ->callback([$this, 'save'])
        );
    }


    public function getAttributes(Request $request): array
    {
        return Setting::where('setting', 'like', $this->getId() . '.%')
            ->get()
            ->keyBy(fn (Setting $setting) => Str::replaceFirst($this->getId() . '.', '', $setting->setting))
            ->map(fn (Setting $setting) => $setting->value)
            ->toArray();
    }

    public function save(Request $request)
    {
        $settings = $request->get('attributes');
        foreach($settings as $setting => $value) {
            $model = Setting::firstOrNew(['setting' => $this->getId() . '.' . $setting]);
            $model->value = $value;
            $model->save();
        }
    }
}

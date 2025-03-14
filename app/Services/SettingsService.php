<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Blade;


class SettingsService
{
    public function boot()
    {
        // Create a custom Blade directive to get settings
        Blade::directive('getSetting', function ($expression) {
            return "<?php echo \App\Services\SettingsService::getSettingValue($expression); ?>";
        });
    }
    static function setSetting(int $companyId, string $key, $value, string $type): Setting
    {
        return Setting::updateOrCreate(
            [
                'company_id' => $companyId,
                'key' => $key,
                'type' => $type,
            ],
            [
                'value' => is_array($value) ? json_encode($value) : $value,
            ]
        );
    }

    static function getSettingValue(int $companyId, string $key, string $type, $default = null)
    {
        $setting = Setting::where('company_id', $companyId)
            ->where('key', $key)
            ->where('type', $type)
            ->first();

        if ($setting) {
            return self::parseValue($setting->value);
        }

        return $default;
    }

    static function parseValue(string $value)
    {
        $decoded = json_decode($value, true);
        return (json_last_error() === JSON_ERROR_NONE) ? $decoded : $value;
    }
}

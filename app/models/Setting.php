<?php

namespace App\Models;

use App\Core\Model;

class Setting extends Model
{
    protected string $table = 'settings';

    private const ALLOWED_KEYS = [
        'company_name',
        'slogan',
        'email',
        'phone',
        'whatsapp',
        'instagram',
        'facebook',
        'tiktok',
        'address',
        'description',
        'meta_description',
        'hero_title',
        'hero_subtitle',
        'contact_notification_email',
    ];

    public function get(string $key, ?string $default = null): ?string
    {
        $result = $this->whereOne('setting_key', $key);
        return $result ? $result['setting_value'] : $default;
    }

    public function set(string $key, ?string $value): bool
    {
        if (!in_array($key, self::ALLOWED_KEYS, true)) {
            return false;
        }

        $existing = $this->whereOne('setting_key', $key);

        if ($existing) {
            return $this->db->update(
                'settings',
                ['setting_value' => $value, 'updated_at' => date('Y-m-d H:i:s')],
                'setting_key = ?',
                [$key]
            );
        }

        $this->db->insert('settings', [
            'setting_key' => $key,
            'setting_value' => $value,
        ]);
        return true;
    }

    public function getAll(): array
    {
        $settings = $this->db->fetchAll('SELECT * FROM settings ORDER BY id ASC');
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }
        return $result;
    }

    public function updateMultiple(array $data): bool
    {
        foreach ($data as $key => $value) {
            if (in_array($key, self::ALLOWED_KEYS, true)) {
                $this->set($key, is_array($value) ? '' : trim((string) $value));
            }
        }
        return true;
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['setting_key' => 'site_name', 'setting_value' => 'Helpdesk System', 'setting_type' => 'string', 'category' => 'general', 'description' => 'Website name'],
            ['setting_key' => 'ticket_prefix', 'setting_value' => 'TICKET', 'setting_type' => 'string', 'category' => 'tickets', 'description' => 'Prefix for ticket numbers'],
            ['setting_key' => 'auto_assign_tickets', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'tickets', 'description' => 'Automatically assign tickets to available staff'],
            ['setting_key' => 'default_priority', 'setting_value' => '2', 'setting_type' => 'integer', 'category' => 'tickets', 'description' => 'Default priority for new tickets'],
            ['setting_key' => 'max_file_size', 'setting_value' => '10', 'setting_type' => 'integer', 'category' => 'uploads', 'description' => 'Maximum file size in MB'],
            ['setting_key' => 'allowed_file_types', 'setting_value' => '["jpg","jpeg","png","gif","pdf","doc","docx","txt"]', 'setting_type' => 'json', 'category' => 'uploads', 'description' => 'Allowed file extensions'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}

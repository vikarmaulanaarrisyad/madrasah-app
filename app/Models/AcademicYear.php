<?php

namespace App\Models;

class AcademicYear extends Model
{
    public function statusText()
    {
        $text = '';

        switch ($this->is_active) {
            case '1':
                $text = 'Aktif';
                break;

            default:
                $text = 'Tidak Aktif';
                break;
        }

        return $text;
    }

    public function statusColor()
    {
        $color = '';

        switch ($this->is_active) {
            case '1':
                $color = 'success';
                break;

            default:
                $color = 'danger';
                break;
        }

        return $color;
    }
}

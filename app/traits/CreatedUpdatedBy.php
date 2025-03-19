<?php

namespace App\traits;

use Illuminate\Support\Facades\Auth;

trait CreatedUpdatedBy
{
    protected function getAutoFillFields(): array
    {
        return $this->autoFillFields ?? [];
    }

    public static function bootCreatedUpdatedBy()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                if (in_array('created_by', $model->getAutoFillFields(), true)) {
                    $model->created_by = Auth::id();
                }
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                if (in_array('updated_by', $model->getAutoFillFields(), true)) {
                    $model->updated_by = Auth::id();
                }
            }
        });
    }
}

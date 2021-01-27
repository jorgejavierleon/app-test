<?php

namespace App\Models\Traits;

use App\Models\Meta;

trait HasMeta 
{
    public function metas()
    {
        return $this->hasMany(Meta::class, 'model_id');
    }

    public function hasMetas() : bool
    {
        return !!$this->metas()->count();
    }

    public function getMeta(string $key)
    {
        $meta = $this->metas()->where(['key' => $key])->first();
        return $meta ? $meta->value : null;
    }

    public function updateOrCreateMeta(string $key, $value)
    {
        $meta = $this->metas()->where(['key' => $key])->first();
        if($meta){
            return $meta->update(['value' => $value]);
        }

        return Meta::create([
            'key' => $key,
            'value' => $value,
            'model_type' => get_class($this),
            'model_id' => $this->id,
        ]);
    }

    public function deleteMeta(string $key)
    {
        $meta = $this->metas()->where(['key' => $key])->first();
        if($meta){
            return $meta->delete();
        }
        return;
    }
}

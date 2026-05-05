<?php

namespace App\Traits;

trait HashRouteKey
{
    // Esto hace que en las URLs se use el ID codificado
        public function getRouteKey()
        {
            // Esto convierte el 1 en MQ== para la URL
            return base64_encode($this->getKey());
        }

    public function resolveRouteBinding($value, $field = null)
    {
        // Esto convierte el MQ== de vuelta a 1 para la base de datos
        try {
            $id = base64_decode($value);
            return $this->where($field ?? $this->getKeyName(), $id)->firstOrFail();
        } catch (\Exception $e) {
            abort(404);
        }
    }
}   
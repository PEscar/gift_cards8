<?php

namespace App\Models;

use App\Models\Sede;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
	protected $table = 'venta_producto';

    const TIPO_GIFTCARD = 1;
    const TIPO_NORMAL = 2;

    const ESTADO_VALIDA = 1;
    const ESTADO_CONSUMIDA = 2;
    const ESTADO_ASIGNADA = 3;
    const ESTADO_VENCIDA = 4;

    public static function findGiftCardByCodigo($codigo)
    {
    	return self::where('codigo', $codigo)->first();
    }

    // SCOPES

    public function scopeGiftCards($query)
    {
    	return $query->whereNotNull('codigo_gift_card');
    }

    // END SCOPES

    // ACCESORS

    public function getEstadoAttribute()
    {
        // Una GC puede tener 3 estados: asignada, vencida o valida.

        if ( !is_null($this->fecha_asignacion) )
        {
            return self::ESTADO_ASIGNADA;
        }
        else if( $this->fecha_vencimiento < \Illuminate\Support\Carbon::now() )
        {
            return self::ESTADO_VENCIDA;
        }
        else if( $this->fecha_vencimiento >= \Illuminate\Support\Carbon::now() )
        {
            return self::ESTADO_VALIDA;
        }

        return self::ESTADO_CONSUMIDA;
    }

    // END ACCESORS

    // RELATIONS

    public function asignadaPor()
    {
        return $this->belongsTo(User::class, 'asignacion_id', 'id');
    }

    public function consumidaPor()
    {
        return $this->belongsTo(User::class, 'consumicion_id', 'id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    // END RELATIONS

    // FUNCTIONS

    public function generateGiftCardCode()
    {
        do
        {
            $this->codigo_gift_card = \Str::random(8);

            $validator = \Validator::make(['codigo_gift_card' => $this->codigo_gift_card], [
                'codigo_gift_card' => 'unique:venta_producto,codigo_gift_card',
            ]);

        } while ( $validator->fails() );
    }

    public function asignar($sede, $nro_mesa, $user_id)
    {
        $this->fecha_asignacion = \Illuminate\Support\Carbon::now();
        $this->asignacion_id = $user_id;
        $this->sede_id = $sede;
        $this->nro_mesa = $nro_mesa;

        return $this;
    }

    public function desasignar()
    {
        $this->fecha_asignacion = null;
        $this->asignacion_id = null;
        $this->sede_id = null;
        $this->nro_mesa = null;

        return $this;
    }

    // END FUNCTIONS
}

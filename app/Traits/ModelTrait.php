<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

trait ModelTrait
{
    public function scopeSearch( Builder $q ): void
    {
        if ( $this->filter['where'] )
        {
            foreach ( $this->filter['where'] as $f )
            {
                $value = trim( request( $f ) );
                $q->when( $value, function ( Builder $s_q ) use ( $f, $value ) {
                    $s_q->where( $f, $value );
                } );
            }
        }

        if ( $this->filter['like'] )
        {
            foreach ( $this->filter['like'] as $k => $columns )
            {
                $search = trim( request( $k ) );
                $q->when( $search, function ( Builder $s_q ) use ( $columns, $search ) {
                    $s_q->where( function ( $s_s_q ) use ( $columns, $search, $s_q ) {
                        foreach ( $columns as $col )
                        {
                            $s_s_q->orWhere( $col, 'LIKE', "%" . $search . "%" );
                        }
                    } );
                } );
            }
        }
    }
}

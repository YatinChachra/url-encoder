<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class UrlEncoding
 * @package App\Models
 */
class UrlEncoding extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'host',
        'encoded_url'
    ];
}
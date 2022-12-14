<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // アプリケーション側でcreateなどできない値を記述する
  // 🔽 以下の処理を記述

  protected $guarded = [
    'id',
    'created_at',
    'updated_at',
  ];
  public static function getAllOrderByUpdated_at()
  {
    return self::orderBy('updated_at', 'desc')->get();
  }

}

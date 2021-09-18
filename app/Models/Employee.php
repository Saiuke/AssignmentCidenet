<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
   use HasFactory;

   public $table = 'employees';
   protected $fillable = [
       'first_name', 'middle_name', 'last_name', 'other_name', 'work_country', 'document_type', 'document_number', 'email', 'department', 'status', 'start_date'
   ];
}

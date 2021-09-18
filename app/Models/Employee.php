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

    /**
     * Create a new mail address for an employee
     */
    public function generateEmailAddress()
    {
       $emailDomain = $this->work_country == "Estados Unidos" ? 'cidenet.com.us' : 'cidenet.com.co';
       $newMailAddress = trim(strtolower($this->first_name . '.' . $this->middle_name));
       if(!$this->checkMailUniqueness($newMailAddress . '@' . $emailDomain)){
           // This will be always unique because of the ID
           $this->email = $newMailAddress . '.' . $this->id . '@' . $emailDomain;
       }else{
           $this->email = $newMailAddress . '@' . $emailDomain;
       }
        return $this->save();
    }

    /**
     * Check if an email address already exists
     *
     * @param $emailAddress
     * @return bool
     */
    public function checkMailUniqueness($emailAddress)
    {
       if (Employee::where('email', $emailAddress)) {
           return false;
       }
       return true;
    }
}

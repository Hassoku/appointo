<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeGroup extends Model
{
    protected $guarded = ['id'];
    protected $table = 'employee_groups';
}

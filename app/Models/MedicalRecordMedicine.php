<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecordMedicine extends Model
{
    use HasFactory;

    protected $table = 'medical_records_medicines';

    protected $fillable = [
        'id_medical_record',
        'id_medicine',
        'amount',
    ];
}

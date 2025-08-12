<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAttachment extends Model
{
    public function attachment_type_rel()
    {
        return $this->belongsTo(AttachmentType::class,'attachment_type', 'id' );
    }
}

<?php

// ContactBusinessFilter.php

namespace App\Filters;

class ContactBusinessFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('appmail_contact_business', $value);
    }
}

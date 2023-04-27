<?php

// BusinessFilter.php

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class BusinessFilter extends AbstractFilter
{
    protected $filters = [
        'appmail_contact_business' => ContactBusinessFilter::class
    ];
}

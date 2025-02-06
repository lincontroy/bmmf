<?php

namespace App\Traits;


trait ActionButtonTrait
{
    public function buttonUD($uAction, $dAction)
    {
        return '<a href="' . $uAction . '" class="btn btn-primary-soft btn-sm me-1" title="Edit"><i class="fa fa-edit"></i></a>' .
            '<a href="' . $dAction . '" class="btn btn-danger-soft btn-sm delete" title="Delete"><i class="fa fa-trash"></i></a>';
    }

    public function buttonAjaxUD($uAction, $dAction)
    {
        return '<a href="' . $uAction . '" class="btn btn-primary-soft btn-sm me-1 edit" title="Edit"><i class="fa fa-edit"></i></a>' .
            '<a href="' . $dAction . '" class="btn btn-danger-soft btn-sm delete" title="Delete"><i class="fa fa-trash"></i></a>';
    }
}
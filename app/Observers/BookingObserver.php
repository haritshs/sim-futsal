<?php
namespace App\Observers;

use App\Notifications\BookSuccess;
use App\Jabatan;
use App\Admin;

class BookingObserver
{
    public function created(Jabatan $item)
    {
        $author = $item->admin;
        $admins = Admin::all();
        foreach ($admins as $row) {
            $row->notify(new BookSuccess($item, $author));
        }
    }
}
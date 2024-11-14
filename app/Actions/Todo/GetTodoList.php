<?php

namespace App\Actions\Todo;

use App\Models\Todo;

class GetTodoList
{
   public function list()
   {
      $perPage = request('per_page', 6);
      $status = request('status', 'all');
      
      return Todo::latest()
         ->when($status != 'all', function($query) use($status) {
            $status = $status == 'pending' ? 0 : 1;
            $query->where('status', $status);
         })
         ->paginate($perPage);
   }
}

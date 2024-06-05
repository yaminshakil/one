<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{

      /**
       * The table associated with the model.
       *
       * @var string
       */
      protected $table = 'uploads';

      /**
       * The user that uploaded this file
       */
      public function user()
      {
          return $this->belongsTo(User::class);
      }

      /**
       * The answer that this upload belongs to
       */
      public function answer()
      {
          return $this->belongsTo(Answer::class);
      }

}

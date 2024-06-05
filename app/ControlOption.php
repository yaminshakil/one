<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlOption extends Model
{

      /**
       * The table associated with the model.
       *
       * @var string
       */
      protected $table = 'controloptions';

      /**
       * The section that this control belongs to
       */
      public function control()
      {
          return $this->belongsTo(Control::class);
      }

}

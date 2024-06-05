<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

      /**
       * The table associated with the model.
       *
       * @var string
       */
      protected $table = 'answers';

      /**
       * The attributes that should be cast to native types.
       *
       * @var array
       */
      protected $casts = [
          'locked' => 'boolean',
      ];

      /**
       * The company that answered the question
       */
      public function company()
      {
          return $this->belongsTo(Team::class);
      }

      /**
       * The control this answers
       */
      public function control()
      {
          return $this->belongsTo(Control::class);
      }

      /**
       * The control option that was chosen (if any)
       */
      public function option()
      {
          return $this->belongsTo(ControlOption::class);
      }

      /**
       * Who saved the answer
       */
      public function user()
      {
          return $this->belongsTo(User::class);
      }

      /**
       * The uploads associated with this answer
       */
      public function uploads()
      {
          return $this->hasMany(Upload::class);
      }

      /**
       * The number of uploaded files for this answer
       */
      public function uploadCount()
      {
        return $this->uploads->count();
      }

}

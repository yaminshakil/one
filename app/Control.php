<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{

      /**
       * The table associated with the model.
       *
       * @var string
       */
      protected $table = 'controls';

      public const types = [
            1=>'Basic',
            2=>'Derived'
          ];

      public const answerTypes = [
            0=>'Boolean',
            1=>'Integer',
            2=>'ShortText',
            3=>'LongText',
            4=>'Select List',
            5=>'Radio Buttons'
          ];

      /**
       * The section that this control belongs to
       */
      public function section()
      {
          return $this->belongsTo(Section::class);
      }

      /**
       * The options that are part of this control.
       */
      public function options()
      {
          return $this->hasMany(ControlOption::class);
      }

      /**
       * The answers to this control.
       */
      public function answers()
      {
          return $this->hasMany(Answer::class);
      }

      /**
       *
       */
      public function answered()
      {
          return $this->answers()->where('locked',1)->where('archived',0);
      }

}

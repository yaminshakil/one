<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\DB;

class Section extends Model
{

      /**
       * The table associated with the model.
       *
       * @var string
       */
      protected $table = 'sections';

      /**
       * The controls that are part of this section.
       */
      public function controls()
      {
          return $this->hasMany(Control::class);
      }

      /**
       * Get the number of answered questions for this section
       * @param int $company_id
       */
      public function answeredCount($team_id)
      {
          $q = DB::table('sections')
              ->join('controls', 'sections.id', '=', 'controls.section_id')
              ->join('answers', 'controls.id', '=', 'answers.control_id')
              ->select('answers.id')
              ->where('sections.id',$this->id)
              ->where('answers.team_id',$team_id)
              ->where('answers.locked',1)
              ->get()->count();
          return $q;
      }
}

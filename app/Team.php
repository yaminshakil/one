<?php

namespace App;

use Laravel\Spark\Team as SparkTeam;
use Illuminate\Support\Facades\DB;

class Team extends SparkTeam
{
    /**
     * Extending SparkTeam
     */
    // public function shouldHaveOwnerVisibility()
    // {
    //     $this->makeVisible([
    //         'card_brand',
    //         'card_last_four',
    //         'card_country',
    //         'billing_address',
    //         'billing_address_line_2',
    //         'billing_city',
    //         'billing_state',
    //         'billing_zip',
    //         'billing_country',
    //         'extra_billing_information',
    //         'org_address1',
    //     ]);
    // }

    /**
     * Get how many users are associated with the team
     */
    public function userCount()
    {
        return $this->users->count();
    }

    /**
     * The answers that belong to the team.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * The answers that belong to the team.
     */
    public function answersByControl($control_id)
    {
        return $answers->where('control_id',$control_id)->where('archived',0);
    }

    /**
     * Get how many questions the team has answered
     */
    public function answerCount()
    {
        return $this->answers->where('archived',0)->count();
    }

    /**
     * Get how many questions the team has answered and locked
     */
    public function answeredCount()
    {
        return $this->answers->where('archived',0)->where('locked',1)->count();
    }

    /**
     * Get the file references uploaded for this team
     */
    public function getFiles()
    {
        $q = DB::table('answers')
            ->join('uploads', 'answers.id', '=', 'uploads.answer_id')
            ->join('users', 'users.id', '=', 'uploads.user_id')
            ->join('controls', 'controls.id', '=', 'answers.control_id')
            ->select(['uploads.*','users.name as username','controls.control_number','answers.control_id'])
            ->where('answers.team_id',$this->id)
            ->orderby('control_number')
            ->get();
        return $q;
    }


}

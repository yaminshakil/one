<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;
use Laravel\Spark\Exceptions\IneligibleForPlan;
use Carbon\Carbon;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Redport Information Assurance LLC',
        'product' => 'NIST 800-171 Compliance Tool',
        'street' => '814 W. Diamond Ave. Suite 370',
        'location' => 'Gaithersburg, MD 20878',
        'phone' => '703.229.6709',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'support@redport-ia.com';

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'g.wilson@redport-ia.com',
        'k.knudsen@redport-ia.com',
        'd.vannostrand@redport-ia.com',
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = false;

    protected function customizeRoles()
    {
        Spark::defaultRole('member');

          Spark::roles([
              'manager' => 'Manager',
              'member' => 'User',
          ]);
    }

    /**
     * Different from booted()  =(
     *
     * @return void
     */
    public function register()
    {
      Spark::referToTeamAs('assessment');
    }

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {


//        Spark::noAdditionalTeams();
//        Spark::hideTeamSwitcher();
        Spark::minimumPasswordLength(12);

        Spark::useStripe()->noCardUpFront()->teamTrialDays(5);
        Spark::collectBillingAddress();

        Spark::freeTeamPlan()
            ->yearly()
            ->maxTeams(1)
            ->maxTeamMembers(1)
            ->features([
                'Dashboard View'
            ]);

        Spark::teamPlan('Basic', 'basic-200mb')
            ->price(2000)
            ->yearly()
            ->maxTeams(1)
            ->maxTeamMembers(5)
            ->maxCollaborators(5)
            ->attributes(['storage'=>'200'])  //in MB
            ->features([
                '5 User Accounts', '1 Assessment', 'POA&M Report', 'System Security Report', '1 Hour Free Consulting', '200MB Document Storage'
            ]);
        Spark::teamPlan('Standard', 'standard-600mb')
            ->price(4000)
            ->yearly()
            ->maxTeams(3)
            ->maxTeamMembers(15)
            ->maxCollaborators(15)
            ->attributes(['storage'=>'600'])
            ->features([
                '10 User Accounts', '3 Assessments', 'Basic Plan Features', 'Additional Reporting', '2 Hours Free Consulting', '600MB Document Storage'
            ]);
        Spark::teamPlan('Pro', 'pro-1400mb')
            ->price(7000)
            ->yearly()
            ->maxTeams(7)
            ->maxTeamMembers(30)
            ->maxCollaborators(30)
            ->attributes(['storage'=>'1400'])
            ->features([
                '30 User Accounts', '7 Assessments', 'Standard Plan Features', '3 Hours Free Consulting', '1.4GB Document Storage'
            ]);
        Spark::teamPlan('Consultant 15G', 'consultant-15g')
            ->price(37500)
            ->yearly()
            ->maxTeams(50)
            ->maxTeamMembers(1)
            ->maxCollaborators(1)
            ->attributes(['storage'=>'15000'])
            ->features([
                '1 User Account', '50 Assessments', 'Pro Plan Features', '1 Hour Free Consulting', '15GB Document Storage'
            ]);
        Spark::teamPlan('Consultant 30G', 'consultant-30g')
            ->price(50000)
            ->yearly()
            ->maxTeams(100)
            ->maxTeamMembers(1)
            ->maxCollaborators(1)
            ->attributes(['storage'=>'30000'])
            ->features([
                '1 User Account', '100 Assessments', 'Pro Plan Features', '1 Hour Free Consulting', '30GB Document Storage'
            ]);

        Spark::validateUsersWith(function() {
            return [
              'name' => 'required|max:255',
              'company' => 'required|max:255',
              'email' => 'required|email|max:255|unique:users',
              'password' => 'required|confirmed|min:12',
              'terms' => 'required|accepted',
            ];
        });

        Spark::createUsersWith(function ($request){
            $user = Spark::user();
            $data = $request->all();
            $user->forceFill([
              'name' => $data['name'],
              'company' => $data['company'],
              'email' => $data['email'],
              'password' => bcrypt($data['password']),
              'last_read_announcements_at' => Carbon::now(),
              'trial_ends_at' => Carbon::now()->addDays(Spark::trialDays()),
            ])->save();
            return $user;
        });

        //Prevent them from downgrading when they exceed certain limits
        Spark::checkPlanEligibilityUsing(function ($user, $plan) {
          $filesize = 0;
          $tooManyFiles = 'You are not eligible for this plan based on your current number of files stored.';
          //get all teams for the user
          foreach ($user->teams as $team) {
            $files = $team->getFiles();
            foreach($files as $file){
              $filesize += $file->size;
            }
          }
          $mb = $filesize/1024000;
          if (
              ($plan->name == 'Free' && $mb > 0)
              || ($plan->name == 'Basic' && $mb > 200)
              || ($plan->name == 'Standard' && $mb > 600)
              || ($plan->name == 'Pro' && $mb > 1400)
              || ($plan->name == 'Consultant 1' && $mb > 20000)
              || ($plan->name == 'Consultant 2' && $mb > 40000)
            ) {
            $base = log($filesize) / log(1024);
            $suffix = array("", "KB", "MB", "GB", "TB");
            $f_base = floor($base);
            $humansize = round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
            throw IneligibleForPlan::because($tooManyFiles.' ('.$humansize.')');
          }
          return true;
        });
    }


}

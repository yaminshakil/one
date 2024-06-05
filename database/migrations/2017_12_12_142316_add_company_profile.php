<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('org_name',64)->nullable();
            $table->string('org_address1',64)->nullable();
            $table->string('org_address2',64)->nullable();
            $table->string('org_city',32)->nullable();
            $table->string('org_state',2)->nullable();
            $table->string('org_zip',10)->nullable();
            $table->integer('org_employeecount')->default(1);

            $table->string('sys_name',128)->nullable();

            $table->string('owner_name',64)->nullable();
            $table->string('owner_title',64)->nullable();
            $table->string('owner_company',64)->nullable();
            $table->string('owner_address1',64)->nullable();
            $table->string('owner_address2',64)->nullable();
            $table->string('owner_city',32)->nullable();
            $table->string('owner_state',2)->nullable();
            $table->string('owner_zip',10)->nullable();
            $table->string('owner_email',64)->nullable();
            $table->string('owner_phone',12)->nullable();

            $table->string('authorizing_name',64)->nullable();
            $table->string('authorizing_title',64)->nullable();
            $table->string('authorizing_company',64)->nullable();
            $table->string('authorizing_address1',64)->nullable();
            $table->string('authorizing_address2',64)->nullable();
            $table->string('authorizing_city',32)->nullable();
            $table->string('authorizing_state',2)->nullable();
            $table->string('authorizing_zip',10)->nullable();
            $table->string('authorizing_email',64)->nullable();
            $table->string('authorizing_phone',12)->nullable();

            $table->string('other_name',64)->nullable();
            $table->string('other_title',64)->nullable();
            $table->string('other_company',64)->nullable();
            $table->string('other_address1',64)->nullable();
            $table->string('other_address2',64)->nullable();
            $table->string('other_city',32)->nullable();
            $table->string('other_state',2)->nullable();
            $table->string('other_zip',10)->nullable();
            $table->string('other_email',64)->nullable();
            $table->string('other_phone',12)->nullable();

            $table->string('security_name',64)->nullable();
            $table->string('security_title',64)->nullable();
            $table->string('security_company',64)->nullable();
            $table->string('security_address1',64)->nullable();
            $table->string('security_address2',64)->nullable();
            $table->string('security_city',32)->nullable();
            $table->string('security_state',2)->nullable();
            $table->string('security_zip',10)->nullable();
            $table->string('security_email',64)->nullable();
            $table->string('security_phone',12)->nullable();

            $table->text('op_status_operational')->nullable();
            $table->text('op_status_dev')->nullable();
            $table->text('op_status_majormod')->nullable();
            $table->text('sys_desc')->nullable();
            $table->text('sys_env')->nullable();
            $table->string('op_sys_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('org_name');
            $table->dropColumn('org_address1');
            $table->dropColumn('org_address2');
            $table->dropColumn('org_city');
            $table->dropColumn('org_state');
            $table->dropColumn('org_zip');
            $table->dropColumn('org_employeecount');
            $table->dropColumn('org_name');
            $table->dropColumn('sys_name');
            $table->dropColumn('owner_name');
            $table->dropColumn('owner_title');
            $table->dropColumn('owner_company');
            $table->dropColumn('owner_addr');
            $table->dropColumn('owner_email');
            $table->dropColumn('owner_phone');
            $table->dropColumn('authorizing_name');
            $table->dropColumn('authorizing_title');
            $table->dropColumn('authorizing_company');
            $table->dropColumn('authorizing_addr');
            $table->dropColumn('authorizing_email');
            $table->dropColumn('authorizing_phone');
            $table->dropColumn('other_name');
            $table->dropColumn('other_title');
            $table->dropColumn('other_company');
            $table->dropColumn('other_addr');
            $table->dropColumn('other_email');
            $table->dropColumn('other_phone');
            $table->dropColumn('security_name');
            $table->dropColumn('security_title');
            $table->dropColumn('security_company');
            $table->dropColumn('security_addr');
            $table->dropColumn('security_email');
            $table->dropColumn('security_phone');
            $table->dropColumn('op_status_operational');
            $table->dropColumn('op_status_dev');
            $table->dropColumn('op_status_majormod');
            $table->dropColumn('sys_desc');
            $table->dropColumn('sys_env');
            $table->dropColumn('op_sys_type');
        });
    }
}

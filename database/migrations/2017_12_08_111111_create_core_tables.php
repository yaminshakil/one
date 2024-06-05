<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code'); //3.1
            $table->integer('order')->default(1);
            $table->timestamps();
        });
        Schema::create('controls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('control_number'); //3.1.1
            $table->integer('order')->default(1);
            $table->text('description');
            $table->text('question');
            $table->text('guidance');
            $table->text('additional_text')->nullable();
            $table->text('how_to_answer')->nullable();
            $table->string('video_ref')->nullable();
            $table->integer('control_type');    //1: basic, 2: derived
            $table->integer('answer_type');        //0: boolean, 1: integer, 2: select, 3: text, 4: radio
            $table->boolean('document_req')->default(false);
            $table->text('nist_controls')->nullable();
            $table->text('isoiec_controls')->nullable();
            $table->integer('section_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
        Schema::create('controloptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('order');
            $table->integer('risk')->default(0);
            $table->integer('control_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('control_id')->references('id')->on('controls')->onDelete('cascade');
        });
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->text('answer')->nullable();
            $table->integer('answer_int')->nullable();  //in case it is a numerical field that can be summed
            $table->text('comment')->nullable();
            $table->boolean('archived')->default(false);
            $table->boolean('locked')->default(false);
            $table->integer('control_id')->unsigned();
            $table->integer('option_id')->unsigned()->default(0);
            $table->integer('team_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('control_id')->references('id')->on('controls')->onDelete('cascade');
            //$table->foreign('option_id')->references('id')->on('controloptions')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');      //how they want to describe it, default to "File"
            $table->string('name');       //what they sent
            $table->string('filename');   //how we store it internally
            $table->string('mimetype')->nullable();
            $table->integer('size')->unsigned();
            $table->integer('answer_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        //Custom user fields
        Schema::table('users', function (Blueprint $table) {
            $table->string('company',64)->nullable();
          });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('company');
        });
        Schema::dropIfExists('uploads');
        Schema::dropIfExists('controloptions');
        Schema::dropIfExists('controls');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('answers');
    }
}

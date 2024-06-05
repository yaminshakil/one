<?php

use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $i=1;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Access Control',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Awareness and Training',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Audit and Accountability',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Configuration Management',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Identification and Authentication',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Incident Response',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Maintenance',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Media Protection',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Personnel Security',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Physical Protection',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Risk Assessment',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'Security Assessment',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'System and Communications Protection',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
      $i++;
      DB::table('sections')->insert([
          'id'      => $i,
          'name'    => 'System and Information Integrity',
          'code'    => '3.'.$i,
          'order'   => $i*2,
      ]);
    }
}

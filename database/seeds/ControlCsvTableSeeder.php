<?php

use Illuminate\Database\Seeder;

class ControlCsvTableSeeder extends Seeder
{
    protected $table='controls';
    protected $filename='';
    protected $heading_map=array(
        'Security Requirement Family' => 'section_id',
        'Security Requirement Identifier' => 'control_number',
        'Security Requirement Type' => 'control_type',
        'Security Requirement Description' => 'description',
        'Recommended Implementation Guidance' => 'guidance',
        'User Questions' => 'question',
        'Answer Type' => 'answer_type',
        'Additional Text' => 'additional_text',
        'Answer Content' => 'how_to_answer',
        'Video' => 'video_ref',
    );

    protected $inc=0;

    protected $sections=array();

    public function __construct() {
        $this->filename=app_path() . '/../database/csv/nist-800-171-controls.csv';

        foreach (DB::table('sections')->get() AS $section) {
            $this->sections[$section->name] = $section->id;
        }
    }

   /**
    * Collect data from a given CSV file and return as array
    *
    * @param $filename
    * @param string $delimiter
    * @return array|bool
    */
    private function seedFromCSV($filename, $delimiter = ",")
    {
        if(!file_exists($filename) || !is_readable($filename))
        {
            return FALSE;
        }


        $header = NULL;
        $data = array();

        if(($handle = fopen($filename, 'r')) !== FALSE) {
            while(($row = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
                if(!$header) {
                    $header = $row;
                    foreach ($header AS &$h) {
                        if (isset($this->headings_map[$h])) {
                            $h=$this->headings_map[$h];
                        }
                    }
                    ksort($header);
                } else {
                    $data[] = $this->formatSeed(array_combine($header, $row));
                }
            }
            fclose($handle);
        }

        return $data;
    }

    protected function formatSeed($arr) {
        $seed=array(
            'id' => ++$this->inc,
            'section_id' => (isset($this->sections[$arr['Security Requirement Family']]))? $this->sections[$arr['Security Requirement Family']] : 0,
            'control_number' => $arr['Security Requirement Identifier'],
            'control_type' => (strtolower($arr['Security Requirement Type']) == 'basic')? 1 : 2,
            'answer_type' => ($arr['Answer Type'] == 'boolean')? 0 : 1,
            'description' => $arr['Security Requirement Description'],
            'question' => $arr['User Questions'],
            'order' => $this->inc*2,
            'additional_text' => $arr['Additional Text'],
            //'how_to_answer' => $arr['how_to_answer'],
            'document_req' => $arr['Documentation Required?'],
            'video_ref' => $arr['Video'],
            'nist_controls' => '',
            'isoiec_controls' => '',
            'guidance' => $arr['Recommended Implementation Guidance'],
        );

        return $seed;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->table)->delete();
        $seedData = $this->seedFromCSV($this->filename, ',');
        foreach ($seedData as $data) {
          DB::table($this->table)->insert($data);
        }
    }
}

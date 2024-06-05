<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use App\User;
use App\Team;
use App\Section;
use App\Control;
use App\ControlOption;
use App\Answer;

use ZipArchive;


class ReportController extends Controller
{

  private $ssp_template = '/assets/xlsx/NIST SSP Report Template v0.1.xlsx';
  private $poam_template = '/assets/xlsx/POAM_Template.xlsx';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('teamSubscribed');
    }

    /**
     * Show a Plan of Action and Milestones (POAM) report
     * @return Response
     */
    public function poam()
    {
        $user = request()->user();
        if (!$user->currentTeam){
          alert()->error('Error','You are not on a team');
          return redirect('/');
        }
        $team = $user->currentTeam;
        $controls = Control::orderBy('order')->get();
        $answers = $team->answers;
        return view('app/report/poam',compact('team','controls','answers'));
    }

    /**
     * Download the POAM as an excel file
     * @return file
     */
    public function poamGenerate()
    {
        $user = request()->user();
        if (!$user->currentTeam){
          alert()->error('Error','You are not on a team');
          return redirect('/');
        }
        $team = $user->currentTeam;
        $controls = Control::orderBy('order')->get();
        $answers = $team->answers;

        try{
          $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(resource_path().$this->poam_template);

          $spreadsheet->getProperties()
              ->setCreator("OneSevenOne by Redport Information Assurance")
              ->setLastModifiedBy($user->name)
              ->setTitle("NIST 800-171 POA&M")
              ->setSubject("POA&M")
              ->setDescription("Plan of Actions & Milestones")
              ->setKeywords("poam,nist 800-171")
              ->setCategory("compliance");

          $worksheet = $spreadsheet->getActiveSheet();

          //System Name
          $worksheet->setCellValue('B2', $team->name);

          //create the data validation lookups
          $v_risk = $spreadsheet->getActiveSheet()->getCell('D6')
              ->getDataValidation();
          $v_risk->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
          $v_risk->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
          $v_risk->setShowDropDown(true);
          $v_risk->setFormula1('Lookups!$A$1:$A$3');
          $v_status = $spreadsheet->getActiveSheet()->getCell('H6')
              ->getDataValidation();
          $v_status->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
          $v_status->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
          $v_status->setShowDropDown(true);
          $v_status->setFormula1('Lookups!$B$1:$B$6');
          $v_accepted = $spreadsheet->getActiveSheet()->getCell('I6')
              ->getDataValidation();
          $v_accepted->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
          $v_accepted->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
          $v_accepted->setShowDropDown(true);
          $v_accepted->setFormula1('Lookups!$C$1:$C$2');

          $i=0;
          $offset=5;
          foreach ($controls as $control){
            $answer=false;
            foreach ($answers as $a){
              if ($a->control_id==$control->id){
                $answer=$a;
              }
            }
            if ($answer && $answer->answer_int==1){
              continue;
            }
            $i++;

            $worksheet->setCellValue('A'.($i+$offset), $i);
            $worksheet->setCellValue('B'.($i+$offset), $control->description);
            $worksheet->setCellValue('C'.($i+$offset), $control->control_number);
            $worksheet->getCell('D'.($i+$offset))->setDataValidation(clone $v_risk);
            $worksheet->getCell('H'.($i+$offset))->setDataValidation(clone $v_status);
            $worksheet->getCell('I'.($i+$offset))->setDataValidation(clone $v_accepted);
            if ($answer!=false){
              $worksheet->setCellValue('J'.($i+$offset), $answer->updated_at);
              $worksheet->setCellValue('P'.($i+$offset), 'Self-Assessment - ' . $answer->updated_at);
            }

          }

          //add the borders
          $styleArray = array(
              'font' => array(
                'size'=>11,
              ),
              'borders' => array(
                  'allBorders' => array(
                      'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                      'color' => array('argb' => 'FF555555'),
                  ),
              ),
          );

          $worksheet->getStyle('A'.$offset.':P'.($i+$offset))->applyFromArray($styleArray);

          //Save
          $local = Storage::disk('local');
          $lwd = $local->url('');
          $file = "..".$lwd."app/Assessment_POAM_".$team->id.".xlsx";
          $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
          $writer->save($file);
          //Send
          return response()->download($file)->deleteFileAfterSend(true);
        }
        catch(\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
          //@TODO:: syslog
          alert()->error('Error','Contact support with error POAMXLSERR');
          return redirect()->route('app');
        }
        alert()->success('Download','Download initiated');
        return redirect()->route('app');
      }

    /**
     * Highlight where they need to provide supporting documentation
     * @return Response
     */
    public function missingDocumentation()
    {
      $user = request()->user();
      if (!$user->currentTeam){
        alert()->error('Error','You are not on a team');
        return redirect('/');
      }
      $team = $user->currentTeam;
      $controls = Control::orderBy('order')->get();
      $answers = $team->answers;
      $answerTypes = Control::answerTypes;
      return view('app/report/missing',compact('team','controls','answers','answerTypes'));
    }

    /**
     * System Security Plan
     * @return Response
     */
    public function ssp()
    {
      if (!file_exists(resource_path().$this->ssp_template)){
        alert()->error('Error','Contact support with error SSPXLSDNE');
        return redirect()->route('app');
      }

      $user = request()->user();
      if (!$user->currentTeam){
        alert()->error('Error','You are not on a team');
        return redirect('/');
      }
      $team = $user->currentTeam;
      $controls = Control::all();
      $answers = $team->answers;
      $completed = ($controls->count() <= $answers->count());
      return view('app/report/ssp-form',compact('user','team','completed'));
    }

    /**
     * System Security Plan Generation
     * @return Response
     */
    public function sspGenerate()
    {
      $validation = [
        'org_name' => 'required|string|max:64',
        'sys_name' => 'required|string|max:128',

        'owner_name' => 'required|string|max:128',
        'owner_title' => 'required|string|max:64',
        'owner_company' => 'required|string|max:64',
        'owner_address1' => 'required|string|max:64',
        'owner_address2' => 'present',
        'owner_city' => 'required|string|max:32',
        'owner_state' => 'required|string|max:2',
        'owner_zip' => 'required|string|max:10',
        'owner_email' => 'required|string|max:64',
        'owner_phone' => 'required|string|max:12',
        'op_sys_type'       => 'required|string|in:Major Application,General Support System',

        'authorizing_name' => 'required|string|max:128',
        'authorizing_title' => 'required|string|max:64',
        'authorizing_company' => 'required|string|max:64',
        'authorizing_address1' => 'required|string|max:64',
        'authorizing_address2' => 'present',
        'authorizing_city' => 'required|string|max:32',
        'authorizing_state' => 'required|string|max:2',
        'authorizing_zip' => 'required|string|max:10',
        'authorizing_email' => 'required|email|max:64',
        'authorizing_phone' => 'required|string|max:12',
        'other_name'     => 'present',
        'other_title'     => 'present',
        'other_company'     => 'present',
        'other_address1' => 'required_with:other_name',
        'other_address2' => 'present',
        'other_city' => 'required_with:other_address1',
        'other_state' => 'required_with:other_address1',
        'other_zip' => 'required_with:other_address1',
        'other_email'     => 'required_with:other_name',
        'other_phone'     => 'required_with:other_name',
        'security_name'     => 'required|string|max:128',
        'security_title'    => 'required|string|max:64',
        'security_company'  => 'required|string|max:64',
        'security_address1' => 'required|string|max:64',
        'security_address2' => 'present',
        'security_city' => 'required|string|max:32',
        'security_state' => 'required|string|max:2',
        'security_zip' => 'required|string|max:10',
        'security_email'    => 'required|email|max:64',
        'security_phone'    => 'required|string|max:12',
        'op_status_operational' => 'required_without_all:op_status_dev,op_status_majormod|string|max:255|nullable',
        'op_status_dev'         => 'required_without_all:op_status_operational,op_status_majormod|string|max:255|nullable',
        'op_status_majormod'    => 'required_without_all:op_status_dev,op_status_operational|string|max:255|nullable',
        'sys_desc'          => 'required|string|max:1024',
        'sys_env'           => 'required|string|max:1024',
//        'ssp_approval_date '=> 'present',  //not being found for some reason
      ];

      $user = request()->user();
      if (!$user->currentTeam){
        alert()->error('Error','You are not on a team');
        return redirect('/');
      }
      $team = $user->currentTeam;
      $controls = Control::orderBy('order')->get();
      $answers = $team->answers;

      if (!file_exists(resource_path().$this->ssp_template)){
        alert()->error('Error','Contact support with error SSPXLSDNE');
        return redirect()->route('app');
      }

      request()->validate($validation);

      //TODO:: SAVE TO DATASTORE
      $team->forceFill([
        'org_name' => request()->org_name,
        'sys_name' => request()->sys_name,
        'op_sys_type' => request()->op_sys_type,
        'owner_name' => request()->owner_name,
        'owner_title' => request()->owner_title,
        'owner_company' => request()->owner_company,
        'owner_address1' => request()->owner_address1,
        'owner_address2' => request()->owner_address2,
        'owner_city' => request()->owner_city,
        'owner_state' => request()->owner_state,
        'owner_zip' => request()->owner_zip,
        'owner_email' => request()->owner_email,
        'owner_phone' => request()->owner_phone,
        'authorizing_name' => request()->authorizing_name,
        'authorizing_title' => request()->authorizing_title,
        'authorizing_company' => request()->authorizing_company,
        'owner_address1' => request()->owner_address1,
        'owner_address2' => request()->owner_address2,
        'owner_city' => request()->owner_city,
        'owner_state' => request()->owner_state,
        'owner_zip' => request()->owner_zip,
        'authorizing_email' => request()->authorizing_email,
        'authorizing_phone' => request()->authorizing_phone,
        'other_name' => request()->other_name,
        'other_title' => request()->other_title,
        'other_company' => request()->other_company,
        'owner_address1' => request()->owner_address1,
        'owner_address2' => request()->owner_address2,
        'owner_city' => request()->owner_city,
        'owner_state' => request()->owner_state,
        'owner_zip' => request()->owner_zip,
        'other_email' => request()->other_email,
        'other_phone' => request()->other_phone,
        'security_name' => request()->security_name,
        'security_title' => request()->security_title,
        'security_company' => request()->security_company,
        'owner_address1' => request()->owner_address1,
        'owner_address2' => request()->owner_address2,
        'owner_city' => request()->owner_city,
        'owner_state' => request()->owner_state,
        'owner_zip' => request()->owner_zip,
        'security_email' => request()->security_email,
        'security_phone' => request()->security_phone,
        'op_status_operational' => request()->op_status_operational,
        'op_status_dev' => request()->op_status_dev,
        'op_status_majormod' => request()->op_status_majormod,
        'op_sys_type' => request()->op_sys_type,
        'sys_desc' => request()->sys_desc,
        'sys_env' => request()->sys_env,
      ])->save();

      // $control->control_number = request()->control_number;

      try{
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(resource_path().$this->ssp_template);

        $spreadsheet->getProperties()
            ->setCreator("OneSevenOne by Redport Information Assurance")
            ->setLastModifiedBy($user->name)
            ->setTitle("NIST 800-171 SSP")
            ->setSubject(request()->org_name." SSP")
            ->setDescription(
                request()->sys_name." System Security Plan"
            )
            ->setKeywords("ssp,nist 800-171")
            ->setCategory("compliance");
        // $worksheetNames = $reader->listWorksheetNames($this->ssp_template);
        $spreadsheet->setActiveSheetIndex(0);

        //Company Name
        $spreadsheet->getActiveSheet()->setCellValue('B2', request()->org_name);
        //Info System
        $spreadsheet->getActiveSheet()->setCellValue('B3', request()->sys_name);
        //Info System Owner
        $rowArray = array(' ',
          request()->owner_name,
          request()->owner_title,
          request()->owner_company,
          request()->owner_address1.' '.request()->owner_address2.', '.request()->owner_city.', '.request()->owner_state.' '.request()->owner_zip,
          request()->owner_email,
          request()->owner_phone,
        );
        $columnArray = array_chunk($rowArray, 1);
        $spreadsheet->getActiveSheet()->fromArray($columnArray,NULL,'B4');
        //Authorizing Official
        $rowArray = array(' ',
          request()->authorizing_name,
          request()->authorizing_title,
          request()->authorizing_company,
          request()->authorizing_address1.' '.request()->authorizing_address2.', '.request()->authorizing_city.', '.request()->authorizing_state.' '.request()->authorizing_zip,
          request()->authorizing_email,
          request()->authorizing_phone,
        );
        $columnArray = array_chunk($rowArray, 1);
        $spreadsheet->getActiveSheet()->fromArray($columnArray,NULL,'B11');
        //Other Designated Contracts
        if (request()->other_name!=''){
          $rowArray = array(' ',
            request()->other_name,
            request()->other_title,
            request()->other_company,
            request()->other_address1.' '.request()->other_address2.', '.request()->other_city.', '.request()->other_state.' '.request()->other_zip,
            request()->other_email,
            request()->other_phone,
          );
          $columnArray = array_chunk($rowArray, 1);
          $spreadsheet->getActiveSheet()->fromArray($columnArray,NULL,'B18');
        }
        //Assignment of Security Responsibility
        $rowArray = array(' ',
          request()->security_name,
          request()->security_title,
          request()->security_company,
          request()->security_address1.' '.request()->security_address2.', '.request()->security_city.', '.request()->security_state.' '.request()->security_zip,
          request()->security_email,
          request()->security_phone,
        );
        $columnArray = array_chunk($rowArray, 1);
        $spreadsheet->getActiveSheet()->fromArray($columnArray,NULL,'B25');
        //Information System Operating Status
        $rowArray = array(' ',
          request()->op_status_operational,
          request()->op_status_dev,
          request()->op_status_majormod,
        );
        $columnArray = array_chunk($rowArray, 1);
        $spreadsheet->getActiveSheet()->fromArray($columnArray,NULL,'B32');
        //Other
        $rowArray = array(
          request()->op_sys_type,
          request()->sys_desc,
          request()->sys_env,
        );
        $columnArray = array_chunk($rowArray, 1);
        $spreadsheet->getActiveSheet()->fromArray($columnArray,NULL,'B36');

        // count of Y Controls
        $implemented = 0;
        foreach ($answers as $answer) {
          if ($answer->answer_int==1){
            $implemented++;
          }
        }
        $rowArray = array(
          $implemented,
          $controls->count() - $implemented,
          date('Y-m-d'),
          request()->ssp_approval_date
        );
        $columnArray = array_chunk($rowArray, 1);
        $spreadsheet->getActiveSheet()->fromArray($columnArray,NULL,'B39');

        //Switch to sheet 2 and replace [Company Name]
        $spreadsheet->setActiveSheetIndex(1);
        for ($i=2; $i<=111; $i++){
          $cellValue = $spreadsheet->getActiveSheet()->getCell('E'.$i)->getValue();
          $update = str_replace('[Company Name]',request()->org_name,$cellValue);
          $spreadsheet->getActiveSheet()->setCellValue('E'.$i, $update);
          //control #
          $c = $spreadsheet->getActiveSheet()->getCell('B'.$i)->getValue();
          foreach ($answers as $key => $answer) {
            if ($answer->control->control_number == $c){
              $comment = $answer->comment;
              if ($answer->answer_int==1){
                $comment = "Implemented. ".$comment;
              }
              $spreadsheet->getActiveSheet()->setCellValue('F'.$i, $comment);
            }
          }
        }
        //Insert answer comments

        // Signature Page
        $spreadsheet->setActiveSheetIndex(2);
        $cellValue = $spreadsheet->getActiveSheet()->getCell('D1')->getValue();
        $update = str_replace('[Company Name]',request()->org_name,$cellValue);
        $update = str_replace('[System Name]',request()->sys_name,$update);
        $spreadsheet->getActiveSheet()->setCellValue('D1', $update);

        //Return active to cover page
        $spreadsheet->setActiveSheetIndex(0);

        //Save
        $local = Storage::disk('local');
        $lwd = $local->url('');
        $file = "..".$lwd."app/Assessment_SSP_".$team->id.".xlsx";
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($file);
        //Send
        return response()->download($file)->deleteFileAfterSend(true);
      }
      catch(\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        //@TODO:: syslog
        alert()->error('Error','Contact support with error SSPXLSERR');
        return redirect()->route('app');
      }
      alert()->success('Download','Download initiated');
      return redirect()->route('app');
    }

    /**
     * SPackage up all their uploads by Control
     * @return Response
     */
    public function zip()
    {
        $user = request()->user();
        if (!$user->currentTeam){
          alert()->error('Error','You are not on a team');
          return redirect('/');
        }
        $team = $user->currentTeam;
        $files = $team->getFiles();

        //organize the files
        $folders = [];
        $filecount = 0;
        $filesize = 0;
        foreach($files as $file){
          if (!Storage::exists($file->filename)){
            //@TODO:: warn user
            Log::error('File missing: '.$file->filename.' ['.$file->name.']');
            continue;
          }
          if (!isset($folders[$file->control_number])){
            $folders[$file->control_number]=[];
          }
          array_push($folders[$file->control_number],[$file->filename,$file->name]);
          $filecount++;
          $filesize += $file->size;
        }

        $local = Storage::disk('local');

        $zipFileName = 'AssessmentDocumentationPackage.zip';
        $zip = new ZipArchive;
        $zipFullPath = '/tmp/'. md5('assessment'.$team->id).'.zip';

        try{
          //Zip it up
          if ($zip->open($zipFullPath, ZipArchive::CREATE) === TRUE) {
              foreach($folders as $dir=>$folder){
                //make a folder
                $zip->addEmptyDir($dir);
                //add the files to that directory
                foreach($folder as $file){
                  $f = Storage::get($file[0]);
                  Storage::disk('local')->put('tmp/'.$team->id.'/'.md5($file[0]),$f);
                  $zip->addFile(storage_path('app').'/tmp/'.$team->id.'/'.md5($file[0]),$dir.'/'.$file[1]);
                }
              }
              $zip->close();
          }
          else{
            Log::emergency('Could not create temporary zip file');
            throw new \Exception('Could not create zip file.');
          }
          //clean up a bit
          $this->zipFilesCleanup($folders,$team->id);

          // Set Header
          $headers = array(
              'Content-Type' => 'application/octet-stream',
          );
          // Create Download Response
          if(file_exists($zipFullPath)){
              return response()->download($zipFullPath,$zipFileName,$headers)->deleteFileAfterSend(true);
          }
          else{
            Log::emergency('Could not find zip file: '.$zipFullPath);
            throw new \Exception('Could not find zip file. '.$zipFullPath);
          }
        }
        catch(\Exception $e) {
          //@TODO:: syslog
          dd($e);
          alert()->error('Error','Contact support with error ZIPERR');
          Log::emergency('Zip download error'.$e->getMessage());
          if (file_exists($zipFullPath)){
            unlink($zipFullPath);
          }
          return redirect()->route('app');
        }
        alert()->success('Download','Download initiated');
        if (file_exists($zipFullPath)){
          unlink($zipFullPath);
        }
        return redirect()->route('app');
    }

    /**
     * Clean up the temp files we pulled from S3
     */
    protected function zipFilesCleanup($folders,$tid) {
      //clean up
      foreach($folders as $dir=>$folder){
        foreach($folder as $file){
          if (Storage::disk('local')->exists('tmp/'.$tid.'/'.md5($file[0]))){
            Storage::disk('local')->delete('tmp/'.$tid.'/'.md5($file[0]));
          }
        }
      }
      rmdir(storage_path('app').'/tmp/'.$tid);
    }

}

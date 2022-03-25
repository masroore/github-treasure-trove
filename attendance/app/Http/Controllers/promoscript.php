public function graduating_list_script(Request $request){
        //dd($request);
 $cademicyear = Academicyear::where('status',1)->first();
 $academic = $cademicyear->acdemicyear;
 $semester = $cademicyear->semester;
 $level = $request->post('level');
 $prog = $request->post('programme');
 $session = $request->post('session');
 $studentinfo = Studentinfo::where('currentlevel',$level)
 ->where('programme',$prog)
 ->where('session',$session)->get();

    //dd($studentinfo);
    #
 $html = '';
 $html .= '<table id="example1" class="table table-bordered table-striped">
 <thead>
 <tr class="text-center">
 <td colspan="3"> <h1 style="font-size: 25px;">
 GRADUATING LIST <br>
 ACADEMIC YEAR - '.date('Y').' <br>
 PROGRAMME - '.strtoupper($prog).' <br>
 SESSION - '.strtoupper($session).' </h1>
 </td>
 </tr>
 <tr bgcolor="#ccc">
 <th>Fullname</th>
 <th>GPA</th>
 <th>CLASS</th>
 </tr>
 </thead>
 <tbody>';

 foreach ($studentinfo as $student) {
  $userid = $student->user_id;
  $type = $student->type;

  $creg = Coureregistration::where('user_id', $userid)
  ->where('indexnumber',$student->indexnumber)->get();

  $countall = count($creg);

  if ($countall > 0) {
    $i = 1;
    foreach($creg as $row){

      $array = ['D','F'];
      $grade = $row->grade;

      if (in_array($grade,$array)) {
        continue 2;
      }

      if ($i == $countall) {
        //get student gpa

        $gpa = Examresults::where('user_id',$userid)
        ->where('semester',$semester)
        ->where('year',$academic)->first();

        $grade = round($gpa->gpa,2);
        $GRAD = "x->ABSENT,Z->DISQUALIFIED,IC->INCOMPLETE,ADT->AUDITING";

        if ($type == "Degree Programme") {

          if (round($gpa->gpa,2) > 0 && round($gpa->gpa,2) <= 0.99) {
           $class = "Failed";
         }elseif (round($gpa->gpa,2) > 0.99 && round($gpa->gpa,2) <= 1.99) {
          $class = "Pass ";
        }elseif (round($gpa->gpa,2) > 1.99 && round($gpa->gpa,2) <= 2.49) {
         $class = "Third Class";
       }elseif (round($gpa->gpa,2) > 2.49 && round($gpa->gpa,2) <= 2.99) {
         $class = "Second Class Lower";
       }elseif (round($gpa->gpa,2) > 2.99 && round($gpa->gpa,2) <= 3.59) {
        $class = "Second Class Upper";
      }elseif (round($gpa->gpa,2) > 3.59 && round($gpa->gpa,2) <= 4.00) {
       $class = "First Class";
     }

// The above code is a degree code
   }else{


    if (round($gpa->gpa,2) > 0 && round($gpa->gpa,2) <= 0.99) {
     $class = "Failed";
   }elseif (round($gpa->gpa,2) > 0.99 && round($gpa->gpa,2) <= 2.49) {
    $class = "Pass ";
  }elseif (round($gpa->gpa,2) > 2.49 && round($gpa->gpa,2) <= 3.59) {
   $class = "Credit";
 }elseif (round($gpa->gpa,2) > 3.59 && round($gpa->gpa,2) <= 4.00) {
  $class = "Distinction";
}


}




$html .= '
<tr>
<td>'.$student->fullname.'</td>
<td>'.round($gpa->gpa,2).'</td>
<td>'.$class.'</td>
</tr>';




           //check if user has already been added

$checkgradua = GraduatingList::where('indexnumber', $student->indexnumber)
->first();

if ($checkgradua) {
 $checkgradua->gpa = round($gpa->gpa,2);
 $checkgradua->graduatingclas = $class;
 $checkgradua->save();
}else{

            //insert

  $data = [
   'user_id' => $userid,
   'programme' => $prog,
   'session' => $session,
   'type' => $type,
   'academicyear' => $academic,
   'fullname' => $student->fullname,
   'gpa' => round($gpa->gpa,2),
   'graduatingclas' => $class,
   'year' => date('Y'),
   'level' => $level,
   'indexnumber' => $student->indexnumber
 ];


 $new = new GraduatingList($data);
 $new->save();
}

}

$i++;

}
}


}

$html .= '
<tr>
<td colspan="3"><a href="#" class="btn btn-success pull-right">Print</a></td>
</tr>
</tbody>
</table>';


return Response::json(array(
  'success' => 'true',
  'level' => $level,
  'prog' => $prog,
  'session' => $session,
  'academicyear' => $academic,
  'type' => $type
), 200);




}
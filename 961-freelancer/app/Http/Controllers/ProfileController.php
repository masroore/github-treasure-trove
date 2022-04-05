<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Language;
use App\Models\Skills;
use App\Models\User;
use App\Models\UserCertification;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserLanguage;
use App\Models\UserProject;
use App\Models\UserSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;

        $get_skills = Skills::get();
        $get_languages = Language::get();
        $user_skills = UserSkill::with('skillData')->whereuser_id($user_id)->get();
        $user_languages = UserLanguage::with('languageData')->whereuser_id($user_id)->get();
        $countries = Countries::get();
        $experiences = UserExperience::whereuser_id($user_id)->get();
        $educations = UserEducation::whereuser_id($user_id)->get();
        $projects = UserProject::whereuser_id($user_id)->get();
        $certifications = UserCertification::whereuser_id($user_id)->get();
        // dd($user_skills);
        return View::make('frontend.dashboard')->with([
            'skills' => $get_skills,
            'user_skills' => $user_skills,
            'languages' => $get_languages,
            'user_languages' => $user_languages,
            'countries' => $countries,
            'experience' => $experiences,
            'education' => $educations,
            'projects' => $projects,
            'certifications' => $certifications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    // Profile Section
    // public function profile(Request $request){
    //   $user_id = auth()->user()->id;

    //   $get_skills = Skills::get();
    //   $user_skills = UserSkill::with('skillData')->whereuser_id($user_id)->get();
    //   // dd($user_skills);
    //   return View::make('frontend.dashboard')->with([
    //     'skills' => $get_skills,
    //     'user_skills' => $user_skills
    //   ]);
    // }

    public function add_skill(Request $request)
    {
        // dd($request->all());
        $user_skill = new UserSkill();

        $user_skill->user_id = $request->input('user_id');
        $user_skill->skill_id = $request->input('skill_id');
        $user_skill->skill_rate = '0';

        $user_skill->save();

        $current_skill = UserSkill::with('skillData')->whereid($user_skill->id)->first();
        $showCounts = UserSkill::where('user_id', $request->input('user_id'))->count();
        // return $current_skill;
        return response()->json(['status' => 'true', 'skill' => $current_skill, 'count' => $showCounts]);
    }

    // Languages
    public function addLanguage(Request $request)
    {
        // dd($request->all());
        $user_language = new UserLanguage();

        $user_language->user_id = $request->input('user_id');
        $user_language->language_id = $request->input('language_id');
        $user_language->language_rate = $request->language_rate;

        $user_language->save();

        $current_language = UserLanguage::with('languageData')->whereid($user_language->id)->first();
        $showCounts = UserLanguage::where('user_id', $request->input('user_id'))->count();
        // return $current_skill;
        return response()->json(['status' => 'true', 'language' => $current_language, 'count' => $showCounts]);
    }

    // Edit Profile
    public function edit_profile(Request $request)
    {
        // dd($request->all());
        $user_id = auth()->user()->id;
        // dd($request->all());
        $user = User::find($user_id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->gender = $request->input('gender');
        $user->address = $request->input('address');
        $user->country = $request->input('country');
        $user->hourly_rate = $request->input('hourly_rate');
        $user->mobile_number = $request->input('mobile_number');
        $user->age = $request->input('age');
        $user->tagline = $request->input('tagline');
        $user->description = $request->input('description');
        $profile_image = $request->file('profile_image');
        if ('' != $profile_image) {
            $filename = $profile_image->getClientOriginalName();
            $imagename = 'profile-' . mt_rand(000000, 999999) . '.' . $profile_image->getClientOriginalExtension();
            $extension = $profile_image->getClientOriginalExtension();
            // $imagename= $filename;
            $destinationpath = public_path('assets/images/user/profile/');
            $profile_image->move($destinationpath, $imagename);
            $user->profile_image = $imagename;
        }
        $cover_image = $request->file('cover_image');
        if ('' != $cover_image) {
            $filenames = $cover_image->getClientOriginalName();
            $covername = 'cover-' . mt_rand(000000, 999999) . '.' . $cover_image->getClientOriginalExtension();
            $extensions = $cover_image->getClientOriginalExtension();
            // $covername= $filename;
            $destinationpath = public_path('assets/images/user/cover/');
            $cover_image->move($destinationpath, $covername);
            $user->cover_image = $covername;
        }

        return $user->save();
    }

    // Experience
    public function addExperience(Request $request)
    {
        // dd($request->all());
        $user_id = auth()->user()->id;
        $experience = new UserExperience();
        $experience->user_id = $user_id;
        $experience->company_title = $request->input('company_title');
        $experience->start_date = $request->input('start_date');
        $experience->end_date = $request->input('end_date');
        if ('' != $request->input('present_job')) {
            $experience->present_job = $request->input('present_job');
        } else {
            $experience->present_job = 'off';
        }
        $experience->job_title = $request->input('job_title');
        $experience->job_description = $request->input('job_description');

        if ($experience->save()) {
            $data = UserExperience::find($experience->id);
            // dd($data);
            return response()->json(['status' => 'true', 'message' => 'Employment History added successfully', 'data' => $data], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
    }

    public function editExperience(Request $request)
    {
        $id = $request->input('id');
        $experience = UserExperience::find($id);
        $experience->company_title = $request->input('company_title');
        $experience->start_date = $request->input('start_date');
        $experience->end_date = $request->input('end_date');
        if ('' != $request->input('present_job')) {
            $experience->present_job = $request->input('present_job');
        } else {
            $experience->present_job = 'off';
        }
        $experience->job_title = $request->input('job_title');
        $experience->job_description = $request->input('job_description');
        $experience->save();

        return 1;
    }

    public function deleteExperience($id)
    {
        UserExperience::find($id)->delete($id);

        return response()->json([
            'success' => 'Record deleted successfully!',
        ]);
    }

    // Education
    public function addEducation(Request $request)
    {
        $user_id = auth()->user()->id;
        $education = new UserEducation();
        $education->user_id = $user_id;
        $education->institute = $request->input('institute');
        $education->start_date = $request->input('start_date');
        $education->end_date = $request->input('end_date');
        if ('' != $request->input('continue_study')) {
            $education->continue_study = $request->input('continue_study');
        } else {
            $education->continue_study = 'off';
        }
        $education->degree = $request->input('degree');
        $education->area_of_study = $request->input('area_of_study');
        // $education->description = $request->input('description');

        if ($education->save()) {
            $educ = UserEducation::where('id', $education->id)->first();
            // dd($data);
            return response()->json(['status' => 'true', 'message' => 'Education added successfully', 'data' => $educ], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
    }

    public function editEducation(Request $request)
    {
        $id = $request->input('id');
        $education = UserEducation::find($id);
        $education->institute = $request->input('institute');
        $education->start_date = $request->input('start_date');
        $education->end_date = $request->input('end_date');
        if ('' != $request->input('continue_study')) {
            $education->continue_study = $request->input('continue_study');
        } else {
            $education->continue_study = 'off';
        }
        $education->degree = $request->input('degree');
        $education->area_of_study = $request->input('area_of_study');
        // $education->description = $request->input('description');
        $education->save();

        return 1;
    }

    public function deleteEducation($id)
    {
        UserEducation::find($id)->delete($id);

        return response()->json([
            'success' => 'Record deleted successfully!',
        ]);
    }

    // Project
    public function addProject(Request $request)
    {
        $user_id = auth()->user()->id;
        $project = new UserProject();
        $project->user_id = $user_id;
        $project->project_title = $request->input('project_title');
        $project->project_url = $request->input('project_url');
        $project->youtube_link = $request->input('youtube_link');

        $images = [];
        if ($files = $request->file('project_img')) {
            foreach ($files as $file) {
                $imagename = 'project-' . mt_rand(000000, 999999) . '.' . $file->getClientOriginalExtension();
                $extension = $file->getClientOriginalExtension();
                // $imagename= $filename;
                $destinationpath = public_path('assets/images/projects/');
                $file->move($destinationpath, $imagename);

                $images[] = $imagename;
            }
        }
        $project->project_img = implode(',', $images);

        $project_file = $request->file('pdf_files');
        if ('' != $project_file) {
            $filename = $project_file->getClientOriginalName();
            $pdfName = 'project-' . mt_rand(000000, 999999) . '.' . $project_file->getClientOriginalExtension();
            $extension = $project_file->getClientOriginalExtension();
            // $pdfName= $filename;
            $destinationpath = public_path('assets/images/projects/');
            $project_file->move($destinationpath, $pdfName);
            $project->pdf_files = $pdfName;
        }
        $project->project_desc = $request->input('project_desc');

        if ($project->save()) {
            $project = UserProject::where('id', $project->id)->first();
            // dd($data);
            return response()->json(['status' => 'true', 'message' => 'Project added successfully', 'data' => $project], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
    }

    public function editProject(Request $request)
    {
        // dd($request->all());
        $id = $request->input('id');
        $project = UserProject::find($id);
        $project->project_title = $request->input('project_title');
        $project->project_url = $request->input('project_url');
        $project->youtube_link = $request->input('youtube_link');
        $project_file = $request->file('pdf_files');
        if ('' != $project_file) {
            $filename = $project_file->getClientOriginalName();
            $pdfName = 'project-' . mt_rand(000000, 999999) . '.' . $project_file->getClientOriginalExtension();
            $extension = $project_file->getClientOriginalExtension();
            // $pdfName= $filename;
            $destinationpath = public_path('assets/images/projects/');
            $project_file->move($destinationpath, $pdfName);
            $project->pdf_files = $pdfName;
        } else {
            $project->pdf_files = $project->pdf_files;
        }

        $images = [];
        $images[] = $project->project_img;
        if ($files = $request->file('project_img')) {
            foreach ($files as $file) {
                $imagename = 'project-' . mt_rand(000000, 999999) . '.' . $file->getClientOriginalExtension();
                $extension = $file->getClientOriginalExtension();
                // $imagename= $filename;
                $destinationpath = public_path('assets/images/projects/');
                $file->move($destinationpath, $imagename);

                $images[] = $imagename;
            }
            $project->project_img = implode(',', $images);
        } else {
            $project->project_img = implode(',', $images);
        }

        $project->project_desc = $request->input('project_desc');

        $project->save();

        return 1;
    }

    public function deleteProject($id)
    {
        UserProject::find($id)->delete($id);

        return response()->json([
            'success' => 'Record deleted successfully!',
        ]);
    }

    // Certification
    public function addCertificate(Request $request)
    {
        $user_id = auth()->user()->id;
        $certificate = new UserCertification();
        $certificate->user_id = $user_id;
        $certificate->certificate_title = $request->input('certificate_title');
        $certificate->issue_date = $request->input('issue_date');
        $certificate->expire_date = $request->input('expire_date');
        $certificate->certificate_desc = $request->input('certificate_desc');

        if ($certificate->save()) {
            $certificate = UserCertification::where('id', $certificate->id)->first();
            // dd($data);
            return response()->json(['status' => 'true', 'message' => 'Certification added successfully', 'data' => $certificate], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
    }

    public function editCertificate(Request $request)
    {
        $id = $request->input('id');

        $certificate = UserCertification::find($id);
        $certificate->certificate_title = $request->input('certificate_title');
        $certificate->issue_date = $request->input('issue_date');
        $certificate->expire_date = $request->input('expire_date');
        $certificate->certificate_desc = $request->input('certificate_desc');

        $certificate->save();

        return 1;
    }

    public function deleteCertificate($id)
    {
        UserCertification::find($id)->delete($id);

        return response()->json([
            'success' => 'Record deleted successfully!',
        ]);
    }

    public function deleteSkill($id)
    {
        UserSkill::find($id)->delete($id);
        $showCounts = UserSkill::where('user_id', auth()->user()->id)->count();

        return response()->json([
            'success' => 'Record deleted successfully!',
            'count' => $showCounts,
        ]);
    }

    // Delete Language
    public function deleteLanguage($id)
    {
        UserLanguage::find($id)->delete($id);
        $showCounts = UserLanguage::where('user_id', auth()->user()->id)->count();

        return response()->json([
            'success' => 'Language deleted!',
            'count' => $showCounts,
        ]);
    }

    // Verificatiion Request
    public function verification(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $verify_image = $request->file('verification_image');
        if ('' != $verify_image) {
            $filename = $verify_image->getClientOriginalName();
            $imagename = 'verification-' . mt_rand(000000, 999999) . '.' . $verify_image->getClientOriginalExtension();
            $extension = $verify_image->getClientOriginalExtension();
            // $imagename= $filename;
            $destinationpath = public_path('assets/images/user/verification/');
            $verify_image->move($destinationpath, $imagename);
            $user->verification_image = $imagename;
        } else {
            $user->verification_image = $user->verification_image;
        }
        if ($user->save()) {
            return response()->json(['status' => 'true', 'message' => 'Verification request submitted'], 200);
        }

        return response()->json(['status' => 'errorr', 'message' => 'error occured please try again'], 200);
    }

    public function storeImage(Request $request)
    {
        // dd($request->all());
        $user_id = auth()->user()->id;
        // dd($request->all());
        $user = User::find($user_id);

        $data = $request->input('image');
        $name = $request->input('fileProfile');

        $image_array_1 = explode(';', $data);
        $image_array_2 = explode(',', $image_array_1[1]);

        $data = base64_decode($image_array_2[1]);

        $imageName = 'profile-' . time() . '.png';
        $allowed = ['jpeg', 'jpg', 'gif', 'tiff', 'png', 'webp'];
        $file_extension = pathinfo($name, \PATHINFO_EXTENSION);

        $path = public_path() . '/assets/images/user/profile/' . $imageName;

        file_put_contents($path, $data);

        $user->profile_image = $imageName;
        $user->save();

        return response()->json(['name' => $imageName, 'message' => 'Image uploaded successfully']);
    }

    public function storeCoverImage(Request $request)
    {
        // dd($request->all());
        $user_id = auth()->user()->id;
        // dd($request->all());
        $user = User::find($user_id);

        $data = $request->input('image');
        $name = $request->input('fileCover');

        $image_array_1 = explode(';', $data);
        $image_array_2 = explode(',', $image_array_1[1]);

        $data = base64_decode($image_array_2[1]);

        $imageName = 'cover-' . time() . '.png';
        $allowed = ['jpeg', 'jpg', 'gif', 'tiff', 'png', 'webp'];
        $file_extension = pathinfo($name, \PATHINFO_EXTENSION);

        $path = public_path() . '/assets/images/user/cover/' . $imageName;
        file_put_contents($path, $data);

        $user->cover_image = $imageName;
        $user->save();

        return response()->json(['name' => $imageName, 'message' => 'Image uploaded successfully']);
    }
}

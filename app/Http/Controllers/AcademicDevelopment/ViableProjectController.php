<?php

namespace App\Http\Controllers\AcademicDevelopment;

use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use App\Models\ViableProject;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ViableProjectDocument;
use Illuminate\Support\Facades\Storage;
use App\Models\FormBuilder\AcademicDevelopmentForm;
use App\Http\Controllers\Maintenances\LockController;

class ViableProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', ViableProject::class);

        $viable_projects = ViableProject::where('user_id', auth()->id())
                            ->select(DB::raw('viable_projects.*, QUARTER(viable_projects.updated_at) as quarter'))
                            ->orderBy('viable_projects.updated_at', 'desc')->get();
        return view('academic-development.viable-project.index', compact('viable_projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ViableProject::class);

        if(AcademicDevelopmentForm::where('id', 5)->pluck('is_active')->first() == 0)
            return view('inactive');
        $projectFields = DB::select("CALL get_academic_development_fields_by_form_id(5)");

        return view('academic-development.viable-project.create', compact('projectFields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', ViableProject::class);

        $value = $request->input('revenue');
        $value = (float) str_replace(",", "", $value);
        $value = number_format($value,2,'.','');

        $value2 = $request->input('cost');
        $value2 = (float) str_replace(",", "", $value2);
        $value2 = number_format($value2,2,'.','');

        $start_date = date("Y-m-d", strtotime($request->input('start_date')));

        $request->merge([
            'revenue' => $value,
            'cost' => $value2,
            'start_date' => $start_date,
        ]);

        $request->validate([
            // 'revenue' => 'numeric',
            // 'cost' => 'numeric',
            'rate_of_return' => 'numeric',
        ]);

        $input = $request->except(['_token', '_method', 'document', 'rate_of_return']);
        if(AcademicDevelopmentForm::where('id', 5)->pluck('is_active')->first() == 0)
            return view('inactive');
        $input = $request->except(['_token', '_method', 'document']);

        $viable_project = ViableProject::create($input);
        $viable_project->update(['user_id' => auth()->id()]);
        
        $return_rate = ($request->input('rate_of_return') / 100 );
        
        $viable_project->update(['rate_of_return' => $return_rate]);

        $string = str_replace(' ', '-', $request->input('description')); // Replaces all spaces with hyphens.
        $description =  preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        

        if($request->has('document')){
            
            $documents = $request->input('document');
            foreach($documents as $document){
                $temporaryFile = TemporaryFile::where('folder', $document)->first();
                if($temporaryFile){
                    $temporaryPath = "documents/tmp/".$document."/".$temporaryFile->filename;
                    $info = pathinfo(storage_path().'/documents/tmp/'.$document."/".$temporaryFile->filename);
                    $ext = $info['extension'];
                    $fileName = 'ViableProject-'.$description.'-'.now()->timestamp.uniqid().'.'.$ext;
                    $newPath = "documents/".$fileName;
                    Storage::move($temporaryPath, $newPath);
                    Storage::deleteDirectory("documents/tmp/".$document);
                    $temporaryFile->delete();

                    ViableProjectDocument::create([
                        'viable_project_id' => $viable_project->id,
                        'filename' => $fileName,
                    ]);
                }
            }
        }

        \LogActivity::addToLog('Viable demonstration project added.');


        return redirect()->route('viable-project.index')->with('project_success', 'Viable demonstration project has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ViableProject $viable_project)
    {
        $this->authorize('view', ViableProject::class);

        if(AcademicDevelopmentForm::where('id', 5)->pluck('is_active')->first() == 0)
            return view('inactive');
        $projectFields = DB::select("CALL get_academic_development_fields_by_form_id(5)");

        // dd($viable_project);
        $documents = ViableProjectDocument::where('viable_project_id', $viable_project->id)->get()->toArray();

        $values = $viable_project->toArray();

        return view('academic-development.viable-project.show', compact('projectFields', 'viable_project', 'documents', 'values'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ViableProject $viable_project)
    {
        $this->authorize('update', ViableProject::class);

        if(LockController::isLocked($viable_project->id, 20)){
            return redirect()->back()->with('cannot_access', 'Cannot be edited.');
        }

        if(AcademicDevelopmentForm::where('id', 5)->pluck('is_active')->first() == 0)
            return view('inactive');
        $projectFields = DB::select("CALL get_academic_development_fields_by_form_id(5)");

        $documents = ViableProjectDocument::where('viable_project_id', $viable_project->id)->get()->toArray();

        $viable_project->rate_of_return = $viable_project->rate_of_return * 100;
        $values = $viable_project->toArray();

        // dd($values);
        return view('academic-development.viable-project.edit', compact('projectFields', 'viable_project', 'documents', 'values'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ViableProject $viable_project)
    {
        $this->authorize('update', ViableProject::class);

        $value = $request->input('revenue');
        $value = (float) str_replace(",", "", $value);
        $value = number_format($value,2,'.','');

        $value2 = $request->input('cost');
        $value2 = (float) str_replace(",", "", $value2);
        $value2 = number_format($value2,2,'.','');

        $start_date = date("Y-m-d", strtotime($request->input('start_date')));

        $request->merge([
            'revenue' => $value,
            'cost' => $value2,
            'start_date' => $start_date,
        ]);

        $request->validate([
            // 'revenue' => 'numeric',
            // 'cost' => 'numeric',
            'rate_of_return' => 'numeric',
        ]);
        
        if(AcademicDevelopmentForm::where('id', 5)->pluck('is_active')->first() == 0)
            return view('inactive');
        $input = $request->except(['_token', '_method', 'document']);

        $viable_project->update(['description' => '-clear']);

        $viable_project->update($input);

        $string = str_replace(' ', '-', $request->input('description')); // Replaces all spaces with hyphens.
        $description =  preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        
        
        if($request->has('document')){
            
            $documents = $request->input('document');
            foreach($documents as $document){
                $temporaryFile = TemporaryFile::where('folder', $document)->first();
                if($temporaryFile){
                    $temporaryPath = "documents/tmp/".$document."/".$temporaryFile->filename;
                    $info = pathinfo(storage_path().'/documents/tmp/'.$document."/".$temporaryFile->filename);
                    $ext = $info['extension'];
                    $fileName = 'ViableProject-'.$description.'-'.now()->timestamp.uniqid().'.'.$ext;
                    $newPath = "documents/".$fileName;
                    Storage::move($temporaryPath, $newPath);
                    Storage::deleteDirectory("documents/tmp/".$document);
                    $temporaryFile->delete();

                    ViableProjectDocument::create([
                        'viable_project_id' => $viable_project->id,
                        'filename' => $fileName,
                    ]);
                }
            }
        }

        \LogActivity::addToLog('Viable demonstration project updated.');


        return redirect()->route('viable-project.index')->with('project_success', 'Viable demonstration project has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ViableProject $viable_project)
    {
        $this->authorize('delete', ViableProject::class);

        if(LockController::isLocked($viable_project->id, 20)){
            return redirect()->back()->with('cannot_access', 'Cannot be edited.');
        }

        if(AcademicDevelopmentForm::where('id', 5)->pluck('is_active')->first() == 0)
            return view('inactive');
        ViableProjectDocument::where('viable_project_id', $viable_project->id)->delete();
        $viable_project->delete();

        \LogActivity::addToLog('Viable demonstration project deleted.');

        return redirect()->route('viable-project.index')->with('project_success', 'Viable demonstration project has been deleted.');
    }

    public function removeDoc($filename){
        $this->authorize('delete', ViableProject::class);

        if(AcademicDevelopmentForm::where('id', 5)->pluck('is_active')->first() == 0)
            return view('inactive');
        ViableProjectDocument::where('filename', $filename)->delete();

        \LogActivity::addToLog('Viable demonstration project document deleted.');

        return true;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Bueltge\Marksimple\Marksimple;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExportSelected;
use App\Http\Requests\DownloadFile;
use App\Library\CSVFileExporter;
use App\Services\StudentExportService;
use Illuminate\Support\Facades\Validator;
use Storage;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function __construct()
    {
        // Only to test in the browser api auth
        Auth::loginUsingId(1);
    }

    public function welcome()
    {
        $ms = new Marksimple();

        return view('hello', [
            'content' =>  $ms->parseFile('../README.md'),
        ]);
    }

    /**
     * View all students found in the database
     */
    public function viewStudents()
    {
        $students = Student::with('course')->get();

        return view('view_students', compact(['students']));
    }

    /**
     * Exports selected students data to a CSV file
     */
    public function export(ExportSelected $request, StudentExportService $exporter)
    {
        $ids = $request->input('studentId.*', []);
        $csvFilename = $exporter->exportSelected($ids);

        return response()->download(storage_path('app/' . $csvFilename));
    }

    /**
     * Exports all student data to a CSV file
     */
    public function exportStudentsToCSV()
    {
        //
    }

    /**
     * Exports the total number of students that are taking each course to a CSV file
     */
    public function exportCourseAttendenceToCSV()
    {
        //
    }

    /** Optional **/

    /**
     * View all students found in the database
     */
    public function viewStudentsWithVue()
    {
        $students = Student::with('courses')->get();

        return view('view_students_vue', compact(['students']));
    }

    /**
     * Exports all student data to a CSV file
     */
    public function exportStudentsToCsvWithVue()
    {
        //
    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     */
    public function exportCourseAttendenceToCsvWithVue()
    {
        //
    }

    /**
     * View history of exports
     */
    public function viewHistory()
    {
        $files = Storage::files('/');
        $files = array_map(function($file) {
            return [
                'name' => $file,
                'size' => Storage::size($file),
                'last_modified' => Carbon::createFromTimestampUTC(
                    Storage::lastModified($file)
                )
            ];
        }, $files);
        
        return view('view_history', compact(['files']));
    }

    /**
     * Exports selected students data to a CSV file
     */
    public function download(Request $request)
    {
        $file = $request->input('file');

        return response()->download(storage_path('app/' . $file));
    }
}

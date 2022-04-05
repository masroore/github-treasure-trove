<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Models\Attendance;
use App\Models\Book;
use App\Models\Course;
use App\Models\Discount;
use App\Models\Enrollment;
use App\Models\Fee;
use App\Models\InvoiceType;
use App\Models\Paymentmethod;
use App\Models\Student;
use App\Models\Tax;
use App\Traits\PeriodSelection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Prologue\Alerts\Facades\Alert;

class EnrollmentController extends Controller
{
    use PeriodSelection;

    public function __construct()
    {
        parent::__construct();

        // these methods are reserved to administrators or staff members.
        // Only the store method can also be called by teachers to enroll students in their courses
        $this->middleware('permission:enrollments.edit', ['except' => 'store']);
    }

    /**
     * Store the newly created enrollment.
     */
    public function store(StoreEnrollmentRequest $request)
    {
        $course = Course::findOrFail($request->input('course_id'));

        if (Gate::forUser(backpack_user())->denies('enroll-in-course', $course)) {
            abort(403);
        }

        $student = Student::findOrFail($request->input('student_id'));
        $enrollment_id = $student->enroll($course);
        Alert::success(__('Enrollment successfully created'))->flash();

        Log::info(backpack_user()->firstname . ' generated a new enrollment for student ' . $student->name);

        if (backpack_user()->can('enrollments.edit')) {
            return url("/enrollment/$enrollment_id/show");
        }
    }

    public function update(Enrollment $enrollment, Request $request)
    {
        $course = Course::findOrFail($request->input('course_id'));
        $previousCourse = $enrollment->course;

        // if enrollment has children, delete them
        Enrollment::where('parent_id', $enrollment->id)->delete();

        // update enrollment with new course
        $enrollment->update([
            'course_id' => $course->id,
        ]);

        // if the new course has children, create an enrollment as well
        foreach ($course->children as $children_course) {
            $child_enrollment = Enrollment::firstOrNew([
                'student_id' => $enrollment->student_id,
                'course_id' => $children_course->id,
                'parent_id' => $enrollment->id,
            ]);
            $child_enrollment->responsible_id = backpack_user()->id ?? null;
            $child_enrollment->save();
        }

        // delete attendance
        foreach ($enrollment->course->events as $event) {
            Attendance::where('event_id', $event->id)->where('student_id', $enrollment->student_id)->delete();
        }

        foreach ($enrollment->course->children as $child) {
            foreach ($child->events as $event) {
                Attendance::where('event_id', $event->id)->where('student_id', $enrollment->student_id)->delete();
            }
        }

        // TODO delete grades and/or skills

        // display a confirmation message and redirect to enrollment details
        Alert::success(__('The enrollment has been updated'))->flash();

        return "enrollment/$enrollment->id/show";
    }

    /**
     * Create a new cart with the specified enrollment
     * and display the cart.
     */
    public function bill(Enrollment $enrollment)
    {
        Log::info('User # ' . backpack_user()->id . ' is generating a invoice');

        // build an array with products to include
        $products = [];

        foreach (Fee::where('default', 1)->get() as $fee) {
            // Set quantity to 1

            $products[] = $fee;
        }

        $products[] = $enrollment;

        if ($enrollment->course->books->count() > 0) {
            // Set quantity to 1

            foreach ($enrollment->course->books as $book) {
                $products[] = $book;
            }
        }

        // build an array with all contact data
        $clients = [];

        array_push($clients, [
            'name' => $enrollment->student_name,
            'email' => $enrollment->student_email,
            'idnumber' => $enrollment->student->idnumber,
            'address' => $enrollment->student->address,
            'phone' => $enrollment->student->phone,
        ]);

        foreach ($enrollment->student->contacts as $client) {
            $clients[] = $client;
        }

        return view('carts.show', [
            'enrollment' => $enrollment,
            'products' => $products,
            'invoicetypes' => InvoiceType::all(),
            'clients' => $clients,
            'availableBooks' => Book::all(),
            'availableFees' => Fee::all(),
            'availableDiscounts' => Discount::all(),
            'availablePaymentMethods' => Paymentmethod::all(),
            'availableTaxes' => Tax::all(),
        ]);
    }

    public function markaspaid(Enrollment $enrollment)
    {
        $enrollment->markAsPaid();

        return redirect()->back();
    }

    public function markasunpaid(Enrollment $enrollment)
    {
        $enrollment->update(['status_id' => 1]);

        return redirect()->back();
    }

    public function savePrice(Enrollment $enrollment, Request $request)
    {
        $request->validate(['price' => 'required|numeric']);

        $enrollment->update(['total_price' => $request->price]);

        return $enrollment->fresh();
    }

    private function utf8_for_xml($string)
    {
        return preg_replace('/^[\p{L}\p{N}_-]+$/u', ' ', $string);
    }

    public function exportToWord(Enrollment $enrollment)
    {
        App::setLocale(config('app.locale'));
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('enrollment.docx'));

        $templateProcessor->setValue('enrollment_date', $enrollment->date);
        $templateProcessor->setValue('name', $enrollment->student_name);

        $nif = $enrollment->student->idnumber ?: '';
        $phone = $enrollment->student->phone->count() > 0 && $enrollment->student->phone->first()->phone_number ? $enrollment->student->phone->first()->phone_number : '';
        $email = $enrollment->student->email ?: '';
        $address = $enrollment->student->address ?: '';
        $city = $enrollment->student->city ?: '';

        $templateProcessor->setValue('address', $address);
        $templateProcessor->setValue('city', $city);
        $templateProcessor->setValue('phone', $phone);
        $templateProcessor->setValue('nif', $nif);
        $templateProcessor->setValue('email', $email);

        $templateProcessor->setValue('description', $this->utf8_for_xml($enrollment->course->name ?? ''));
        $templateProcessor->setValue('start_date', $enrollment->course->formatted_start_date);
        $templateProcessor->setValue('end_date', $enrollment->course->formatted_end_date);
        $templateProcessor->setValue('volume', $enrollment->course->volume);

        $table = new \PhpOffice\PhpWord\Element\Table([
            'borderSize' => 8,
            'borderColor' => 'black',
            'cellMargin' => 80,
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            'cellSpacing' => 50,
            'width' => 100 * 50,
        ]);

        $firstRowStyle = ['bgColor' => 'd9d9d9'];

        $table->addRow(500, $firstRowStyle);
        $table->addCell(4000, $firstRowStyle)->addText(Str::upper(__('Due Date')));
        $table->addCell(5000, $firstRowStyle)->addText(Str::upper(__('Total')));

        if ($enrollment->scheduledPayments->count() > 0) {
            foreach ($enrollment->scheduledPayments as $payment) {
                $table->addRow(500);
                $table->addCell(4000)->addText($payment->date_for_humans, [], ['spaceAfter' => 0]);
                $table->addCell(5000)->addText($payment->value_with_currency, [], ['spaceAfter' => 0]);
            }
            $templateProcessor->setComplexBlock('payments', $table);
        } else {
            $templateProcessor->setValue('payments', '');
        }

        $path = $templateProcessor->save();

        return response()->download($path)->deleteFileAfterSend(true);
    }
}

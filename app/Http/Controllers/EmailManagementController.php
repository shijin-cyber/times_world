<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Yajra\DataTables\Facades\DataTables;
use App\Jobs\SendEmailNotification;

class EmailManagementController extends Controller
{
    public function index()
    {
        return view('email-management');
    }

    public function getEventsData(Request $request)
    {
        $events = Event::query();

        // Filter by email status if selected
        if ($request->has('status') && $request->status != '') {
            $events->where('email_status', $request->status == 'Sent' ? 1 : 0);
        }

        return DataTables::of($events)
            ->addColumn('mail_status', function ($event) {
                return $event->email_status === 1
                    ? '<span class="badge bg-success">Sent</span>'
                    : '<span class="badge bg-danger">Failed</span>';
            })
            ->addColumn('action', function ($event) {
                if ($event->email_status === 0) {
                    return '<button class="btn btn-warning btn-sm resend-mail" data-id="' . $event->id . '">Resend Mail</button>';
                }
                return '';
            })
            ->rawColumns(['mail_status', 'action'])
            ->make(true);
    }

    public function resendMail($eventId)
    {
        $event = Event::find($eventId);

        if ($event && $event->email_status == 0) {
            try {
                // Instantiate the job and call the handle method directly
                $job = new \App\Jobs\SendEmailNotification($event);
                $job->handle(); 

                return response()->json(['success' => true, 'message' => 'Mail sent successfully.']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to send the mail.'], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Event not found or mail already sent.'], 404);
    }
}
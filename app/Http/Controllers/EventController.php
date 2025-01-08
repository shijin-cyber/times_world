<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Jobs\SendEmailNotification;

class EventController extends Controller
{
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'required|string|max:500',
            'date' => 'required|date|after_or_equal:today',
        ]);
      try{
      
        $event = Event::create($validated);
        // Dispatch the email job
        SendEmailNotification::dispatch($event);
        return redirect()->route('/')->with('success', 'Event registered successfully');
      }
      catch(\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
    }
}
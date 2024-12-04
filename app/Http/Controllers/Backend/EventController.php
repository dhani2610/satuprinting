<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Event;
use App\Models\GuestEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('calendar.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any event !');
        }

        $data['page_title'] = 'Event';
        $data['user'] = Admin::where('type',null)->get();
        // dd($data['user']);
        $guest = GuestEvent::where('id_user',Auth::guard('admin')->user()->id)->get()->pluck('id_event');
        $data['event'] = Event::whereNull('deleted_at')->whereIn('id',$guest)->orderBy('created_at','desc')->get();


        // filter 
        $data['all'] = 'on';
        $data['personal'] = 'on';
        $data['business'] = 'on';
        return view('backend.pages.event.index', $data);
    }
    public function getAllEvent()
    {
        if (is_null($this->user) || !$this->user->can('calendar.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any event !');
        }

        $guest = GuestEvent::where('id_user',Auth::guard('admin')->user()->id)->get()->pluck('id_event');
        $data['event'] = Event::whereIn('id',$guest)->orderBy('created_at','desc')->get();

        return response()->json([
            'msg'=> 'berhasil',
            'event' => $data['event'],
        ]);
        return view('backend.pages.event.index', $data);
    }
    public function getEvent($id){
        $event = Event::find($id);
        $guest = GuestEvent::where('id_event',$event->id)->get();
        return response()->json([
            'msg'=> 'berhasil',
            'event' => $event,
            'guest' => $guest,
        ]);
    }


    public function store(Request $request){
        try {
            $data = new Event();
            $data->eventLabel = $request->eventLabel;
            $data->start_date = $request->eventStartDate;
            $data->end_date = $request->eventEndDate;
            $data->event_url = $request->eventURL;
            $data->location = $request->eventLocation;
            $data->description = $request->eventDescription;
            $data->title = $request->eventTitle;
            $data->allday = $request->allday != null ? 1 : 2;
            $data->created_by = Auth::guard('admin')->user()->id;
            $data->save();

            $participantCreated = new GuestEvent();
            $participantCreated->id_event = $data->id;
            $participantCreated->id_user = $data->created_by;
            $participantCreated->save();

            if ($request->eventGuests != null) {
                foreach ($request->eventGuests as $key => $value) {
                    $participant = new GuestEvent();
                    $participant->id_event = $data->id;
                    $participant->id_user = $value;
                    $participant->save();
                }
            }


            return redirect()->back()->with('success', 'Event saved successfully!');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function update(Request $request,$id){
        try {
            $data = Event::find($id);
            $data->eventLabel = $request->eventLabel;
            $data->start_date = $request->eventStartDate;
            $data->end_date = $request->eventEndDate;
            $data->event_url = $request->eventURL;
            $data->location = $request->eventLocation;
            $data->description = $request->eventDescription;
            $data->title = $request->eventTitle;
            $data->allday = $request->allday != null ? 1 : 2;
            // $data->created_by = Auth::guard('admin')->user()->id;
            $data->save();

            // DELETE PARTICIPANT 
            $part = GuestEvent::where('id_event',$data->id)->get();
            if (count($part) > 0) {
                foreach ($part as $key => $pv) {
                    $gue = GuestEvent::find($pv->id);
                    $gue->delete();
                }
            }
          

            if ($request->eventGuests != null) {

                $cekPart = GuestEvent::where('id_event',$data->id)->get();
                if (!empty($cekPart)) {
                    foreach ($cekPart as $key => $gc) {
                        $delete = GuestEvent::find($gc->id);
                        $delete->delete();
                    }
                }

                  
                $participantCreated = new GuestEvent();
                $participantCreated->id_event = $data->id;
                $participantCreated->id_user = $data->created_by;
                $participantCreated->save();

                foreach ($request->eventGuests as $key => $value) {
                    $participant = new GuestEvent();
                    $participant->id_event = $data->id;
                    $participant->id_user = $value;
                    $participant->save();
                }
            }


            return redirect()->back()->with('success', 'Event updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy($id){
        try {
            $data = Event::find($id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();

            return redirect()->back()->with('success', 'Event deleted successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WeddingController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $wedding = $user->wedding ?? new Wedding();

        return view('customer.wedding.create', compact('user', 'wedding'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $wedding = $user->wedding;

        $validated = $request->validate([
            'groom_name' => 'required|string|max:255',
            'groom_name_en' => 'nullable|string|max:255',
            'bride_name' => 'required|string|max:255',
            'bride_name_en' => 'nullable|string|max:255',
            'groom_parents' => 'nullable|string|max:255',
            'bride_parents' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'lunar_date' => 'nullable|string|max:255',
            'morning_time' => 'nullable|string|max:255',
            'evening_time' => 'nullable|string|max:255',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'venue_location_url' => 'nullable|url',
            'music_url' => 'nullable|url',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'bank_qr_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('cover_image')) {
            $coverFile = $request->file('cover_image');
            $coverName = 'cover_' . time() . '_' . rand(100, 999) . '.' . $coverFile->getClientOriginalExtension();
            $coverFile->move(public_path('uploads/weddings'), $coverName);
            $validated['cover_image'] = 'uploads/weddings/' . $coverName;
        }

        if ($request->hasFile('bank_qr_image')) {
            $qrFile = $request->file('bank_qr_image');
            $qrName = 'qr_' . time() . '_' . rand(100, 999) . '.' . $qrFile->getClientOriginalExtension();
            $qrFile->move(public_path('uploads/qr'), $qrName);
            $validated['bank_qr_image'] = 'uploads/qr/' . $qrName;
        }

        if (!$wedding) {
            $slug = Str::slug($validated['groom_name'] . '-' . $validated['bride_name'] . '-wedding');
            // Ensure unique slug
            if (Wedding::where('slug', $slug)->exists()) {
                $slug .= '-' . rand(100, 999);
            }

            $wedding = Wedding::create(array_merge($validated, [
                'user_id' => $user->id,
                'slug' => $slug,
                'theme_template' => 'married',
                'is_published' => true,
            ]));
        } else {
            $wedding->update($validated);
        }

        return redirect()->route('customer.wedding.template')
            ->with('success', 'រក្សាទុកព័ត៌មានអាពាហ៍ពិពាហ៍ជោគជ័យ! (Wedding details saved successfully!)');
    }

    public function template()
    {
        $user = Auth::user();
        $wedding = $user->wedding;

        if (!$wedding) {
            return redirect()->route('customer.wedding.create')
                ->with('warning', 'សូមបញ្ចូលព័ត៌មានអាពាហ៍ពិពាហ៍ជាមុនសិន! (Please fill wedding details first)');
        }

        return view('customer.wedding.template', compact('user', 'wedding'));
    }

    public function setTemplate(Request $request)
    {
        $request->validate([
            'template' => 'required|in:married,sapphire,ruby',
        ]);

        $wedding = Auth::user()->wedding;
        if ($wedding) {
            $wedding->update(['theme_template' => $request->template]);
        }

        return redirect()->route('customer.guests.index')
            ->with('success', 'ជ្រើសរើស Template ជោគជ័យ! (Invitation template updated)');
    }

    public function showPublic($slug)
    {
        $wedding = Wedding::where('slug', $slug)->firstOrFail();
        
        // Pass guest code or guest name if provided in query string ?guest=...
        $guestQuery = request('guest', '');
        $guest = null;
        $guestName = $guestQuery;

        if ($guestQuery) {
            $foundGuest = \App\Models\Guest::where('invitation_code', $guestQuery)
                ->orWhere('name', $guestQuery)
                ->first();
            if ($foundGuest) {
                $guest = $foundGuest;
                $guestName = $guest->name;
            }
        }

        $templateView = 'wedding-invitation.' . $wedding->theme_template;
        if (!view()->exists($templateView)) {
            $templateView = 'wedding-invitation.index';
        }

        return view($templateView, compact('wedding', 'guest', 'guestName'));
    }

    public function downloadIcs(Request $request)
    {
        $guestName = $request->query('guest', '');
        $title = "អាពាហ៍ពិពាហ៍ - Wedding Invitation";
        $description = "សូមអញ្ជើញ " . $guestName . " ចូលរួមពិធីសិរីមង្គលអាពាហ៍ពិពាហ៍";
        $location = "គេហដ្ឋាន";

        $icsContent = "BEGIN:VCALENDAR\r\n"
            . "VERSION:2.0\r\n"
            . "PRODID:-//Wedding Invitation//KM\r\n"
            . "CALSCALE:GREGORIAN\r\n"
            . "METHOD:PUBLISH\r\n"
            . "BEGIN:VEVENT\r\n"
            . "SUMMARY:{$title}\r\n"
            . "DESCRIPTION:{$description}\r\n"
            . "LOCATION:{$location}\r\n"
            . "DTSTART:20270411T073000Z\r\n"
            . "DTEND:20270411T210000Z\r\n"
            . "STATUS:CONFIRMED\r\n"
            . "SEQUENCE:0\r\n"
            . "END:VEVENT\r\n"
            . "END:VCALENDAR";

        return response($icsContent, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="wedding_event.ics"',
        ]);
    }
}

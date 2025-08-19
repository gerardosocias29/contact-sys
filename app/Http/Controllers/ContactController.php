<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Display a listing of the user's contacts with search and pagination
    public function index(Request $request)
    {
        $query = Contact::where('user_id', \Auth::id());

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('company', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $contacts = $query->orderBy('name')->paginate(10);
        return view('contacts.index', compact('contacts'));
    }

    // Show the form for creating a new contact
    public function create()
    {
        return view('contacts.create');
    }

    // Store a newly created contact
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                // Unique email for this user only
                'unique:contacts,email,NULL,id,user_id,' . Auth::id(),
            ],
        ]);
        $validated['user_id'] = \Auth::id();
        Contact::create($validated);
        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    // Show the form for editing the specified contact
    public function edit(Contact $contact)
    {
        $this->authorizeContact($contact);
        return view('contacts.edit', compact('contact'));
    }

    // Update the specified contact
    public function update(Request $request, Contact $contact)
    {
        $this->authorizeContact($contact);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        $contact->update($validated);
        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    // Remove the specified contact
    public function destroy(Contact $contact)
    {
        $this->authorizeContact($contact);
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
    
    // Helper to ensure the contact belongs to the current user
    protected function authorizeContact(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403);
        }
    }
}

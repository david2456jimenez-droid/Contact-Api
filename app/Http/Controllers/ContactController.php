<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ContactResource::collection($request->user()->contacts()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $contact = $request->user()->contacts()->create($request->validated());

        return (new ContactResource($contact))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Contact $contact)
    {
        abort_if($contact->user_id !== $request->user()->id, 403);

        return new ContactResource($contact);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        abort_if($contact->user_id !== $request->user()->id, 403);

        $contact->update($request->validated());

        return new ContactResource($contact);
    }

    public function destroy(Request $request, Contact $contact)
    {
        abort_if($contact->user_id !== $request->user()->id, 403);

        $contact->delete();

        return response()->noContent();
    }
}

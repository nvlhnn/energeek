<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $candidates = Candidate::with('job', 'skills');

        if ($request->has('job')) {
            $candidates->where('job_id', $request->job);
        }

        if ($request->has('skills')) {
            $candidates->whereHas('skills', function ($q) use ($request) {
                $q->whereIn('skill_id', explode(',', $request->skills));
            });
        }

        $candidates = collect($candidates->paginate(10)->toArray()['data']);



        $candidates = $candidates->map(function ($item, $key) {
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'email' => $item['email'],
                'phone' => $item['phone'],
                'job' => $item['job']['name'],
                'skills' => collect($item['skills'])->pluck('name'),
            ];
        });


        return response()->json([
            'status' => true,
            'message' => 'Candidate list',
            'data' => $candidates,
        ], 201);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required|string',
                'email'     => 'required|email|unique:candidates,email',
                'phone'   => 'required|numeric|unique:candidates,phone',
                'year' => 'required|numeric',
                'skill_ids' => 'required|array',
                'skill_ids.*' => "required|integer|distinct|exists:skills,id",
                'job_id' => 'required|integer|exists:jobs,id'
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors(),
                "data" => null
            ], 400);
        }

        $candidate = new Candidate;

        $candidate->name = $request->name;
        $candidate->email = $request->email;
        $candidate->phone = $request->phone;
        $candidate->year = $request->year;
        $candidate->job_id = $request->job_id;

        // return $candidate;
        $candidate->save();
        $candidate->skills()->attach($request->skill_ids);


        return response()->json([
            "success" => true,
            "message" => "Candidate submitted",
            "data" => [
                'name' => $candidate->name,
                'email' => $candidate->email,
                'phone' => $candidate->phone,
                'job_id' => $candidate->job_id,
                'skills_id' => $request->skill_ids,
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(Candidate $candidate)
    {

        $data = [
            'id' => $candidate->id,
            'name' => $candidate->name,
            'email' => $candidate->email,
            'phone' => $candidate->phone,
            'job' => [
                'id' => $candidate->job->id,
                'name' => $candidate->job->name
            ],
            'skills' => $candidate->skills->map(function ($item, $key) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                ];
            }),
        ];

        return response()->json([
            "success" => true,
            "message" => "Candidate found",
            "data" => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {

        // return $candidate->id;
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required|string',
                'email'     => 'required|email|unique:candidates,email,' . $candidate->id,
                'phone'   => 'required|numeric|unique:candidates,phone,' . $candidate->id,
                'year' => 'required|numeric',
                'skill_ids' => 'required|array',
                'skill_ids.*' => "required|integer|distinct|exists:skills,id",
                'job_id' => 'required|integer|exists:jobs,id'
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors(),
                "data" => null
            ], 400);
        }


        $candidate->name = $request->name;
        $candidate->email = $request->email;
        $candidate->phone = $request->phone;
        $candidate->year = $request->year;
        $candidate->job_id = $request->job_id;

        $candidate->save();
        $candidate->skills()->attach($request->skill_ids);


        return response()->json([
            "success" => true,
            "message" => "Candidate updated",
            "data" => [
                'name' => $candidate->name,
                'email' => $candidate->email,
                'phone' => $candidate->phone,
                'job_id' => $candidate->job_id,
                'skills_id' => $request->skill_ids,
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidate $candidate)
    {
        $candidate->delete();

        return response()->json([
            "success" => true,
            "message" => "Candidate deleted",
            "data" => null
        ], 200);
    }
}

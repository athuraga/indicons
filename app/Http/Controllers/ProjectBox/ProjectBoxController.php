<?php

namespace App\Http\Controllers\ProjectBox;

use App\Http\Controllers\Controller;
use App\ProjectBox;
use Illuminate\Http\Request;

class ProjectBoxController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->role === 'Recruiter') {
            $projectBoxes = ProjectBox::recruiterProjectBoxes($user);

            return response()->json([
                'project_boxes' => $projectBoxes,
            ]);
        }

        $projectBoxes = ProjectBox::with(['project.user'])->where('user_id', $user->id)->latest()->get();
        return response()->json([
            'project_boxes' => $projectBoxes,
        ]);
    }
}

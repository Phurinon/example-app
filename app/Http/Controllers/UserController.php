<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserBio;
use App\Models\PersonalityType;

class UserController extends Controller
{
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->file('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $fileName = time().'_'.$request->file('profile_photo')->getClientOriginalName();
            $filePath = $request->file('profile_photo')->storeAs('uploads/profile_photos', $fileName, 'public');

            $user->profile_photo = $filePath;
            $user->save();
        }

        return redirect()->route('profile.edit')->with('status', 'profile-photo-updated');
    }

    public function showBio()
    {
        $user = Auth::user();
        $bio = $user->bio;
        $personalityTypes = PersonalityType::all();

        return view('profile.show-bio', compact('user', 'bio', 'personalityTypes'));
    }

    public function updateBio(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'bio' => 'required|string',
            'personality_type_id' => 'nullable|exists:personality_types,id',
        ]);

        // อัปเดตหรือสร้างข้อมูล bio
        $bio = $user->bio;
        if ($bio) {
            $bio->update([
                'bio' => $request->input('bio'),
            ]);
        } else {
            $user->bio()->create([
                'bio' => $request->input('bio'),
            ]);
        }

        // อัปเดต personality type หากมีการเลือก
        if ($request->has('personality_type_id')) {
            $user->personality_type_id = $request->input('personality_type_id');
            $user->save();
        }

        // ดีบั๊ก: ตรวจสอบว่า personality_type_id ถูกบันทึกอย่างถูกต้อง
        // dd($user->personality_type_id);

        return redirect()->route('profile.edit')
            ->with('status', 'Profile updated successfully!');
    }


    public function editBio()
    {
        $user = Auth::user();
        $personalityTypes = PersonalityType::all();

        return view('profile.edit-bio', compact('user', 'personalityTypes'));
    }

    public function updatePersonalityType(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'personality_type_id' => 'required|exists:personality_types,id',
        ]);
        
        $user->personality_type_id = $request->input('personality_type_id');
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Personality type updated successfully!');
    }

    // Consolidated edit and show bio methods
    public function edit()
    {
        $user = auth()->user();
        $personalityTypes = PersonalityType::all();

        return view('profile.edit-bio', [
            'user' => $user,
            'personalityTypes' => $personalityTypes,
        ]);
    }

    public function showProfile()
    {
        $user = Auth::user()->load('personalityType'); // Eager load the relationship
        return view('profile.show', compact('user'));
    }
}
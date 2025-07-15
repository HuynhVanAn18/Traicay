<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    // List all staff
    public function index()
    {
        $query = Login::whereHas('roles', function($q) {
            $q->where('name', 'staff');
        });

        if (request()->has('name') && request('name') !== '') {
            $query->where('admin_name', 'like', '%' . request('name') . '%');
        }
        if (request()->has('phone') && request('phone') !== '') {
            $query->where('admin_phone', 'like', '%' . request('phone') . '%');
        }

        $staffs = $query->get();
        return view('admin.staff.index', compact('staffs'));
    }

    // Show form to create new staff
    public function create()
    {
        return view('admin.staff.create');
    }

    // Store new staff
    public function store(Request $request)
    {
        $request->validate([
            'admin_name' => 'required|unique:tbl_admin,admin_name',
            'admin_email' => 'required|email|unique:tbl_admin,admin_email',
            'admin_password' => 'required|min:6',
            'admin_phone' => 'required',
        ]);
        $staff = new Login();
        $staff->admin_name = $request->admin_name;
        $staff->admin_email = $request->admin_email;
        $staff->admin_password = Hash::make($request->admin_password);
        $staff->admin_phone = $request->admin_phone;
        $staff->save();
        // Assign staff role
        $role = Roles::where('name', 'staff')->first();
        if ($role) {
            \Log::info('Attaching role to staff', [
                'role_id' => $role->id_roles,
                'staff_id' => $staff->admin_id
            ]);
            $staff->roles()->attach($role->id_roles);
        } else {
            \Log::error('Staff role not found');
        }
        return redirect()->route('staff.index')->with('message', 'Thêm nhân viên thành công!');
    }

    // Show form to edit staff
    public function edit($id)
    {
        $staff = Login::findOrFail($id);
        return view('admin.staff.edit', compact('staff'));
    }

    // Update staff
    public function update(Request $request, $id)
    {
        $staff = Login::findOrFail($id);
        $request->validate([
            'admin_name' => 'required|unique:tbl_admin,admin_name,' . $staff->admin_id . ',admin_id',
            'admin_email' => 'required|email|unique:tbl_admin,admin_email,' . $staff->admin_id . ',admin_id',
            'admin_phone' => 'required',
        ]);
        $staff->admin_name = $request->admin_name;
        $staff->admin_email = $request->admin_email;
        if ($request->admin_password) {
            $staff->admin_password = Hash::make($request->admin_password);
        }
        $staff->admin_phone = $request->admin_phone;
        $staff->save();
        return redirect()->route('staff.index')->with('message', 'Cập nhật nhân viên thành công!');
    }

    // Delete staff
    public function destroy($id)
    {
        $staff = Login::findOrFail($id);
        $staff->roles()->detach();
        $staff->delete();
        return redirect()->route('staff.index')->with('message', 'Xóa nhân viên thành công!');
    }
}

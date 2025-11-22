<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\Budget;

class BudgetController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Try to get the department for the logged-in head
        $department = Department::where('department_head_id', $user->id)->first();

        if ($department) {
            // Fetch the budget row for this department
            $budget = Budget::where('department_id', $department->id)->first();

            // If no budget exists for the assigned department, show all budgets as fallback
            if (!$budget) {
                $allBudgets = Budget::all();
                return view('head.summary', ['budget' => null, 'allBudgets' => $allBudgets]);
            }

            return view('head.summary', compact('budget'));
        } else {
            // No department assigned — show all budgets as fallback
            $allBudgets = Budget::all();
            return view('head.summary', ['budget' => null, 'allBudgets' => $allBudgets]);
        }
    }
}

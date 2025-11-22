<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class HeadDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Find department assigned to this head
        $department = Department::where('department_head_id', $user->id)->first();

        if (!$department) {
            // No department assigned — send empty/default values
            $totalBudget = 0;
            $totalSpent = 0;
            $chartData = array_fill(1, 12, 0);
            $categoryBreakdown = [];
            $topCategories = [];
            $forecastTotal = 0;
        } else {
            $totalBudget = $department->annual_budget;

            $totalSpent = Expense::where('department_id', $department->id)
                ->where('status', 'approved')
                ->sum('amount');

            // Monthly expenses
            $monthlyExpenses = Expense::selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
                ->where('department_id', $department->id)
                ->where('status', 'approved')
                ->groupByRaw('MONTH(expense_date)')
                ->orderBy('month')
                ->get();

            $chartData = array_fill(1, 12, 0);
            foreach ($monthlyExpenses as $expense) {
                $chartData[(int) $expense->month] = $expense->total;
            }

            // Forecast
            $pastMonths = array_filter($chartData);
            $avgMonthly = count($pastMonths) ? array_sum($pastMonths) / count($pastMonths) : 0;
            $remainingMonths = 12 - count($pastMonths);
            $forecastTotal = $totalSpent + ($avgMonthly * $remainingMonths);

            // Category breakdown
            $categoryBreakdown = Expense::selectRaw('category, SUM(amount) as total')
                ->where('department_id', $department->id)
                ->where('status', 'approved')
                ->groupBy('category')
                ->get();

            $topCategories = $categoryBreakdown->sortByDesc('total')->take(5)->values();
        }

        return view('head.dashboard', compact(
            'totalBudget',
            'totalSpent',
            'chartData',
            'categoryBreakdown',
            'topCategories',
            'forecastTotal'
        ));
    }
}

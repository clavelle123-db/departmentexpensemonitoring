@extends('layouts.app')

@section('content')
    @php
        $spentPercent = $totalBudget > 0 ? round(($totalSpent / $totalBudget) * 100) : 0;
        $remainingPercent = 100 - $spentPercent;
    @endphp

    <div class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
        <!-- Total Budget -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded shadow">
            <h3 class="font-semibold text-gray-700 dark:text-white mb-2">Total Budget</h3>
            <div class="relative w-28 h-28 mx-auto">
                <canvas id="budgetCircle" width="112" height="112"></canvas>
                <div
                    class="absolute inset-0 flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-bold text-lg">
                    100%
                </div>
            </div>
            <p class="mt-3 text-indigo-600 dark:text-indigo-300 font-bold text-lg">
                ₱{{ number_format($totalBudget, 2) }}
            </p>
        </div>

        <!-- Total Spent -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded shadow">
            <h3 class="font-semibold text-gray-700 dark:text-white mb-2">Total Spent</h3>
            <div class="relative w-28 h-28 mx-auto">
                <canvas id="spentCircle" width="112" height="112"></canvas>
                <div
                    class="absolute inset-0 flex items-center justify-center text-red-600 dark:text-red-300 font-bold text-lg">
                    {{ $spentPercent }}%
                </div>
            </div>
            <p class="mt-3 text-red-600 dark:text-red-300 font-bold text-lg">
                ₱{{ number_format($totalSpent, 2) }}
            </p>
        </div>

        <!-- Remaining -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded shadow">
            <h3 class="font-semibold text-gray-700 dark:text-white mb-2">Remaining</h3>
            <div class="relative w-28 h-28 mx-auto">
                <canvas id="remainingCircle" width="112" height="112"></canvas>
                <div
                    class="absolute inset-0 flex items-center justify-center text-green-600 dark:text-green-300 font-bold text-lg">
                    {{ $remainingPercent }}%
                </div>
            </div>
            <p class="mt-3 text-green-600 dark:text-green-300 font-bold text-lg">
                ₱{{ number_format($totalBudget - $totalSpent, 2) }}
            </p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
            <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Budget vs. Actual (Per Department)</h4>
            <canvas id="budgetChart"></canvas>
        </div>

    </div>

    <!-- Department Budgets List with Progress Bar -->
    <div class="mt-10 bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h4 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Department Budgets</h4>

        <div class="space-y-6">
            @foreach ($budgetVsActual as $dept)
                @php
                    $percent = $dept['budget'] > 0 ? round(($dept['spent'] / $dept['budget']) * 100) : 0;
                @endphp

                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <div class="flex justify-between items-center mb-1">
                        <h5 class="text-lg font-medium text-gray-700 dark:text-white">
                            {{ $dept['name'] }}
                        </h5>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            ₱{{ number_format($dept['spent'], 2) }} / ₱{{ number_format($dept['budget'], 2) }}
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full h-4 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-600 dark:bg-indigo-400" style="width: {{ $percent }}%"></div>
                    </div>

                    <p class="text-xs text-gray-500 mt-1 dark:text-gray-300">{{ $percent }}% Spent</p>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const budgetData = @json($budgetVsActual);
        const topSpenders = @json($topSpenders);

        // Circular progress chart helper
        const makeCircle = (elementId, percent, color) => {
            new Chart(document.getElementById(elementId), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [percent, 100 - percent],
                        backgroundColor: [color, '#e5e7eb'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '75%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    responsive: false
                }
            });
        };

        makeCircle('budgetCircle', 100, '#4f46e5');
        makeCircle('spentCircle', {{ $spentPercent }}, '#dc2626');
        makeCircle('remainingCircle', {{ $remainingPercent }}, '#16a34a');

        // Budget vs Actual Bar Chart
        new Chart(document.getElementById('budgetChart'), {
            type: 'bar',
            data: {
                labels: budgetData.map(d => d.name),
                datasets: [{
                        label: 'Budget',
                        data: budgetData.map(d => d.budget),
                        backgroundColor: '#4f46e5'
                    },
                    {
                        label: 'Spent',
                        data: budgetData.map(d => d.spent),
                        backgroundColor: '#ef4444'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Top 5 Spending Users
        new Chart(document.getElementById('topSpendersChart'), {
            type: 'bar',
            data: {
                labels: topSpenders.map(d => d.name),
                datasets: [{
                    label: 'Total Spent',
                    data: topSpenders.map(d => d.total),
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection


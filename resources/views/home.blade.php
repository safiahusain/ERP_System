@extends('layouts.app')

@section('css')
    <style>
        /* ================= GLOBAL ================= */
        .content-wrapper {
            background: linear-gradient(135deg, #eef2f7, #e3e9f3, #f8fafc);
            padding: 20px;
            min-height: 100vh;
        }

        /* ================= HEADER ================= */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 25px;
            border-radius: 14px;
            background: linear-gradient(90deg, #4e73df, #224abe);
            color: #fff;
            margin-bottom: 15px;
        }

        .page-title {
            font-weight: 700;
        }

        /* ================= WELCOME ================= */
        .welcome-box {
            background: #fff;
            border-radius: 14px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
        a {
            color: #ffffff;
        }
        /* ================= CARD ================= */
        .card {
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-6px) scale(1.01);
        }

        /* ================= STAT ================= */
        .stat-card {
            color: #fff;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }

        .stat-card h3 {
            font-size: 34px;
            font-weight: 800;
        }

        .card-icon {
            position: absolute;
            right: 15px;
            bottom: 10px;
            font-size: 50px;
            opacity: 0.25;
        }

        .bg-projects {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }

        .bg-tasks {
            background: linear-gradient(45deg, #1cc88a, #13855c);
        }

        .bg-pending {
            background: linear-gradient(45deg, #f6c23e, #e0a800);
        }

        .bg-completed {
            background: linear-gradient(45deg, #36b9cc, #1a8aa0);
        }

        /* ================= TABLE ================= */
        .table thead {
            background: linear-gradient(90deg, #4e73df, #224abe);
            color: #fff;
        }

        .table tbody tr:hover {
            background: #f1f5ff;
        }

        /* ================= BADGES ================= */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge.bg-warning {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(246, 194, 62, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(246, 194, 62, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(246, 194, 62, 0);
            }
        }

        /* ================= EMPLOYEE ================= */
        .employee-stat {
            margin-bottom: 25px;
        }

        .progress {
            height: 6px;
            border-radius: 10px;
            background: #eaeef5;
        }

        .progress-bar {
            border-radius: 10px;
        }

        /* ================= LIST ================= */
        .card ul li {
            padding: 10px;
            margin-bottom: 8px;
            background: #f4f7ff;
            border-radius: 8px;
            transition: 0.2s;
        }

        .card ul li:hover {
            transform: translateX(5px);
            background: #e9efff;
        }

        /* ================= CHART ================= */
        .chart-box {
            height: 260px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- HEADER -->
        <div class="page-header">
            <h4 class="page-title">ERP Dashboard</h4>
            <div>
                <a href="#">Projects</a> |
                <a href="#">Tasks</a> |
                <a href="#">Employees</a> |
                <a href="#">Reports</a>
            </div>
        </div>

        <!-- WELCOME -->
        <div class="welcome-box">
            <h5>Welcome back, Admin 👋</h5>
            <small>You have 5 pending tasks and 2 deadlines today</small>
        </div>

        <!-- STATS -->
        <div class="row">
            <div class="col-md-3">
                <div class="card stat-card bg-projects">
                    <div class="card-body">
                        <h3>25</h3>
                        <p>Total Projects</p>
                        <i class="mdi mdi-briefcase card-icon"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card bg-tasks">
                    <div class="card-body">
                        <h3>120</h3>
                        <p>Total Tasks</p>
                        <i class="mdi mdi-format-list-checkbox card-icon"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card bg-pending">
                    <div class="card-body">
                        <h3>35</h3>
                        <p>Pending Tasks</p>
                        <i class="mdi mdi-timer-sand card-icon"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card bg-completed">
                    <div class="card-body">
                        <h3>85</h3>
                        <p>Completed Tasks</p>
                        <i class="mdi mdi-check-circle card-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- MIDDLE -->
        <div class="row mt-4">

            <!-- TABLE -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4>⚡ Recent Activity</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Project</th>
                                    <th>Status</th>
                                    <th>Assigned</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Login System</td>
                                    <td>ERP</td>
                                    <td><span class="badge bg-warning">In Progress</span></td>
                                    <td>Ali</td>
                                </tr>
                                <tr>
                                    <td>Dashboard UI</td>
                                    <td>ERP</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>Ahmed</td>
                                </tr>
                                <tr>
                                    <td>Inventory CRUD</td>
                                    <td>Inventory</td>
                                    <td><span class="badge bg-secondary">Pending</span></td>
                                    <td>Sara</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- EMPLOYEES -->
            <div class="col-md-4">
                <div class="card p-3">
                    <h4>Employees</h4>

                    <div class="d-flex justify-content-between mt-2 mb-3">
                        <span>Total</span>
                        <strong>15</strong>
                    </div>

                    <div class="employee-stat">
                        <div class="d-flex justify-content-between">
                            <span>Active</span>
                            <span class="text-success">12</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width:80%"></div>
                        </div>
                    </div>

                    <div class="employee-stat">
                        <div class="d-flex justify-content-between">
                            <span>On Leave</span>
                            <span class="text-warning">3</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width:20%"></div>
                        </div>
                    </div>

                    <div class="employee-stat">
                        <div class="d-flex justify-content-between">
                            <span>Absent</span>
                            <span class="text-danger">3</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" style="width:20%"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- CHART -->
        <div class="row mt-4">

            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Task Status</h5>
                    <div class="chart-box">
                        <canvas id="donutChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card p-3">
                    <h5>Tasks Activity</h5>
                    <div class="chart-box">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <!-- BOTTOM -->
        <div class="row mt-4">

            <div class="col-md-6">
                <div class="card p-3">
                    <h5>Recent Tasks</h5>
                    <ul>
                        <li>Ali created a task</li>
                        <li>Ahmed completed module</li>
                        <li>Sara updated project</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3">
                    <h5>🔔 Notifications</h5>
                    <ul>
                        <li>📌 New project assigned</li>
                        <li>⏰ Task deadline near</li>
                        <li>👤 New employee added</li>
                    </ul>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Tasks Completed',
                        data: [5, 9, 7, 8, 5, 6, 10],
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78,115,223,0.15)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            new Chart(document.getElementById('donutChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Pending', 'In Progress'],
                    datasets: [{
                        data: [85, 35, 20],
                        backgroundColor: ['#1cc88a', '#f6c23e', '#4e73df']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%'
                }
            });

        });
    </script>
@endsection

<?php
use Core\Router;
use App\Controllers\V1\LeadsController;
use App\Controllers\V1\TasksController;

Router::get('api/v1/leads')->controller(LeadsController::class)->action('index');
Router::get('api/v1/leads/{id:\d+}')->controller(LeadsController::class)->action('show');
Router::post('api/v1/leads/store')->controller(LeadsController::class)->action('store');
Router::put('api/v1/leads/{id:\d+}/update')->controller(LeadsController::class)->action('update');
Router::delete('api/v1/leads/{id:\d+}/delete')->controller(LeadsController::class)->action('delete');

Router::get('api/v1/tasks')->controller(TasksController::class)->action('index');
Router::get('api/v1/tasks/{id:\d+}')->controller(TasksController::class)->action('show');
Router::post('api/v1/tasks/store')->controller(TasksController::class)->action('store');
Router::put('api/v1/tasks/{id:\d+}/update')->controller(TasksController::class)->action('update');
Router::delete('api/v1/tasks/{id:\d+}/delete')->controller(TasksController::class)->action('delete');
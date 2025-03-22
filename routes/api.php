<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CertificationController;
use App\Http\Controllers\Api\ContactRequestController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\SocialMediaController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
  // users
  Route::put('/user', [UserController::class, 'update']);
  // social media
  Route::post('/socialMedia', [SocialMediaController::class, 'store']);
  Route::put('/socialMedia/{id}', [SocialMediaController::class, 'update']);
  Route::delete('/socialMedia/{id}', [SocialMediaController::class, 'destroy']);
  // skills
  Route::post('/skills', [SkillController::class, 'store']);
  Route::put('/skills/{id}', [SkillController::class, 'update']);
  Route::delete('/skills/{id}', [SkillController::class, 'destroy']);
  // services
  Route::post('/services', [ServiceController::class, 'store']);
  Route::put('/services/{id}', [ServiceController::class, 'update']);
  Route::delete('/services/{id}', [ServiceController::class, 'destroy']);
  // projects
  Route::post('/projects', [ProjectController::class, 'store']);
  Route::put('/projects/{id}', [ProjectController::class, 'update']);
  Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
  // experiences
  Route::post('/experiences', [ExperienceController::class, 'store']);
  Route::put('/experiences/{id}', [ExperienceController::class, 'update']);
  Route::delete('/experiences/{id}', [ExperienceController::class, 'destroy']);
  // education
  Route::post('/education', [EducationController::class, 'store']);
  Route::put('/education/{id}', [EducationController::class, 'update']);
  Route::delete('/education/{id}', [EducationController::class, 'destroy']);
  // certifications
  Route::post('/certifications', [CertificationController::class, 'store']);
  Route::put('/certifications/{id}', [CertificationController::class, 'update']);
  Route::delete('/certifications/{id}', [CertificationController::class, 'destroy']);
  // contact requests
  Route::get('/contactRequests', [ContactRequestController::class, 'index']);
  Route::delete('/contactRequests/{id}', [ContactRequestController::class, 'destroy']);
});

Route::get('/user', [UserController::class, 'show']);
Route::get('/socialMedia', [SocialMediaController::class, 'index']);
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/experiences', [ExperienceController::class, 'index']);
Route::get('/education', [EducationController::class, 'index']);
Route::get('/certifications', [CertificationController::class, 'index']);
Route::post('/contactRequests', [ContactRequestController::class, 'store']);
